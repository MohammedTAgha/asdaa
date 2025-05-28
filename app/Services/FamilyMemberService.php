<?php

namespace App\Services;

use App\Models\FamilyMember;
use App\Models\Citizen;
use App\Models\Category;
use App\Models\Records\Person;
use App\Models\Records\Relation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;

class FamilyMemberService
{
    public function getParents(Citizen $citizen)
    {
        try {
            return $citizen->familyMembers()
                ->whereIn('relationship', ['father', 'mother'])
                ->get();
        } catch (Exception $e) {
            Log::error('Error fetching parents', [
                'citizen_id' => $citizen->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ أثناء جلب بيانات الوالدين');
        }
    }

    public function getChildren(Citizen $citizen)
    {
        try {
            return $citizen->familyMembers()
                ->whereIn('relationship', ['son', 'daughter'])
                ->orderBy('date_of_birth')
                ->get();
        } catch (Exception $e) {
            Log::error('Error fetching children', [
                'citizen_id' => $citizen->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ أثناء جلب بيانات الأبناء');
        }
    }

    public function searchRecords(Citizen $citizen)
    {
        try {
            // Get the person from Records database
            $person = Person::where('CI_ID_NUM', $citizen->id)->first();
            
            if (!$person) {
                return redirect()->back()->with('error', 'لم يتم العثور على الشخص في السجل المدني');
            }

            // Get relatives from Records database
            $relatives = Relation::with(['relative' => function($query) {
                $query->select('CI_ID_NUM', 'CI_FIRST_ARB', 'CI_FATHER_ARB', 'CI_GRAND_FATHER_ARB', 'CI_FAMILY_ARB','age','full_name','CI_PERSONAL_CD','CI_BIRTH_DT');
            }])->where('CF_ID_NUM', $citizen->id)->get();

            $records_relatives = $relatives->map(function($relation) {
                return [
                    'relative' => $relation->relative,
                    'relation_type' => $relation->relation_name,
                    'relation_code' => $relation->CF_RELATIVE_CD
                ];
            });

            // Prepend the main citizen (father) to the relatives list
            $father = [
                'relative' => $person,
                'relation_type' => 'زوج',
                'relation_code' => null,
                'is_father' => true,
            ];
            $records_relatives = collect([$father])->concat($records_relatives);
            Log::alert('Records relatives', [
                'records_relatives' => $records_relatives
            ]);
            $parents = $this->getParents($citizen);
            $children = $this->getChildren($citizen);
            $result= [
                'parents' => $parents,
                'children' => $children,
                ' $records_relatives' =>  $records_relatives,
                'relatives' => $relatives,
            ];
            return $result;
            // return view('family-members.create', compact('citizen', 'parents', 'children', 'records_relatives'));
        } catch (Exception $e) {
            Log::error('searchRecords service erorr',$e->getMessage());
            return false;
        }
    }

    public function getChildrenRecords(Citizen $citizen, array $filters = [])
    {
        try {
            $id = $citizen->id;
            $person = Person::find($id);
            
            if (!$person) {
                return [];
            }

            $children = $person->getChilds();
            
            // Apply filters
            if (!empty($filters)) {
                $children = $children->filter(function ($child) use ($filters) {
                    $matches = true;
                    
                    // Filter by age
                    if (isset($filters['min_age']) && $child->age < $filters['min_age']) {
                        $matches = false;
                    }
                    if (isset($filters['max_age']) && $child->age > $filters['max_age']) {
                        $matches = false;
                    }
                    
                    // Filter by social status (CI_PERSONAL_CD)
                    if (isset($filters['social_status']) && $child->CI_PERSONAL_CD !== $filters['social_status']) {
                        $matches = false;
                    }
                    
                    // Filter by gender
                    if (isset($filters['gender'])) {
                        $childGender = $child->CI_SEX_CD === 'ذكر' ? 'male' : 'female';
                        if ($childGender !== $filters['gender']) {
                            $matches = false;
                        }
                    }
                    
                    return $matches;
                });
            }
            
            return $children;
        } catch (Exception $e) {
            Log::error('Error getting children records', [
                'citizen_id' => $citizen->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ أثناء جلب بيانات الأبناء');
        }
    }
    
    public function addChildsToDb(Citizen $citizen){ // return persons fo a family
        $id=$citizen->id;
        $person= Person::find($id);
        if ($person) {
            $childs =  $person->getChilds();
            return $childs;
        }
        return [];

    }
    

    public function addMember(array $data, Citizen $citizen) // add member with array of data
    {
        try {
            // Check if member already exists
            $existingMember = $citizen->familyMembers()
                ->where('national_id', $data['national_id'])
                ->first();

            if ($existingMember) {
                throw new Exception('هذا الفرد موجود بالفعل في النظام');
            }

            return $citizen->familyMembers()->create([
                'firstname' => $data['firstname'],
                'secondname' => $data['secondname'],
                'thirdname' => $data['thirdname'] ?? null,
                'lastname' => $data['lastname'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'relationship' => $data['relationship'],
                'national_id' => $data['national_id'],
                'notes' => $data['notes'] ?? null,
            ]);
        } catch (QueryException $e) {
            Log::error('Database error while adding family member', [
                'citizen_id' => $citizen->id,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ في قاعدة البيانات أثناء إضافة الفرد');
        } catch (Exception $e) {
            Log::error('Error adding family member', [
                'citizen_id' => $citizen->id,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function updateMember(FamilyMember $member, array $data)
    {
        try {
            // Check if national_id is being changed and if it already exists
            if ($data['national_id'] !== $member->national_id) {
                $existingMember = FamilyMember::where('national_id', $data['national_id'])
                    ->where('id', '!=', $member->id)
                    ->first();

                if ($existingMember) {
                    throw new Exception('رقم الهوية مستخدم بالفعل من قبل فرد آخر');
                }
            }

            $member->update($data);
            return $member;
        } catch (QueryException $e) {
            Log::error('Database error while updating family member', [
                'member_id' => $member->id,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ في قاعدة البيانات أثناء تحديث بيانات الفرد');
        } catch (Exception $e) {
            Log::error('Error updating family member', [
                'member_id' => $member->id,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function deleteMember(FamilyMember $member)
    {
        try {
            return $member->delete();
        } catch (Exception $e) {
            Log::error('Error deleting family member', [
                'member_id' => $member->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ أثناء حذف الفرد من العائلة');
        }
    }

    public function addChildrenAsMembers(Citizen $citizen, array $filters = [])
    {
        try {
            $children = $this->getChildrenRecords($citizen, $filters);
            $added = 0;
            $errors = [];

            foreach ($children as $child) {
                try {
                    // Check if child already exists as family member
                    $existingMember = $citizen->familyMembers()
                        ->where('national_id', $child->CI_ID_NUM)
                        ->first();

                    if ($existingMember) {
                        $errors[] = "الابن {$child->CI_FIRST_ARB} موجود بالفعل في النظام";
                        continue;
                    }

                    // Parse date of birth
                    $dateOfBirth = null;
                    if ($child->CI_BIRTH_DT) {
                        try {
                            $dateOfBirth = Carbon::createFromFormat('d/m/Y', $child->CI_BIRTH_DT)->format('Y-m-d');
                        } catch (\Exception $e) {
                            Log::warning('Failed to parse child date_of_birth', [
                                'input' => $child->CI_BIRTH_DT,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }

                    // Determine relationship based on gender
                    $relationship = $child->CI_SEX_CD === 'ذكر' ? 'son' : 'daughter';

                    $memberData = [
                        'firstname' => $child->CI_FIRST_ARB,
                        'secondname' => $child->CI_FATHER_ARB,
                        'thirdname' => $child->CI_GRAND_FATHER_ARB,
                        'lastname' => $child->CI_FAMILY_ARB,
                        'national_id' => $child->CI_ID_NUM,
                        'date_of_birth' => $dateOfBirth,
                        'gender' => $child->CI_SEX_CD === 'ذكر' ? 'male' : 'female',
                        'relationship' => $relationship,
                        'notes' => 'تم إضافته تلقائياً كابن'
                    ];

                    $this->addMember($memberData, $citizen);
                    $added++;
                } catch (Exception $e) {
                    $errors[] = "فشل إضافة الابن {$child->CI_FIRST_ARB}: " . $e->getMessage();
                }
            }

            return [
                'added' => $added,
                'errors' => $errors
            ];
        } catch (Exception $e) {
            Log::error('Error adding children as members', [
                'citizen_id' => $citizen->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ أثناء إضافة الأبناء كأعضاء في العائلة');
        }
    }

    /**
     * Add multiple family members to a category
     *
     * @param Category $category
     * @param array $memberIds
     * @param array $pivotData
     * @return void
     * @throws Exception
     */
    public function addMembersToCategory(Category $category, array $memberIds, array $pivotData = [])
    {
        try {
            // Get all family members that exist
            $members = FamilyMember::whereIn('national_id', $memberIds)->get();
            Log::info($members);

            Log::info($members);
            if ($members->isEmpty()) {
                throw new Exception('لم يتم العثور على أي من الأعضاء المحددين');
            }

            // Prepare pivot data for each member
            $syncData = [];
            foreach ($members as $member) {
                $syncData[$member->id] = $pivotData;
            }

            // Sync the members with the category
            $category->familyMembers()->syncWithoutDetaching($syncData);

            return $members;
        } catch (QueryException $e) {
            Log::error('Database error while adding members to category', [
                'category_id' => $category->id,
                'member_ids' => $memberIds,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ في قاعدة البيانات أثناء إضافة الأعضاء إلى الفئة');
        } catch (Exception $e) {
            Log::error('Error adding members to category', [
                'category_id' => $category->id,
                'member_ids' => $memberIds,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function addMemberToCategory(Category $category, array $memberIds, array $pivotData = [])
    {
        try {
            // Get all family members that exist
            $members = FamilyMember::whereIn('national_id', $memberIds)->get();
            Log::info($members);

            Log::info($members);
            if ($members->isEmpty()) {
                throw new Exception('لم يتم العثور على أي من الأعضاء المحددين');
            }

            // Prepare pivot data for each member
            $syncData = [];
            foreach ($members as $member) {
                $syncData[$member->id] = $pivotData;
            }

            // Sync the members with the category
            $category->familyMembers()->syncWithoutDetaching($syncData);

            return $members;
        } catch (QueryException $e) {
            Log::error('Database error while adding members to category', [
                'category_id' => $category->id,
                'member_ids' => $memberIds,
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ في قاعدة البيانات أثناء إضافة الأعضاء إلى الفئة');
        } catch (Exception $e) {
            Log::error('Error adding members to category', [
                'category_id' => $category->id,
                'member_ids' => $memberIds,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Find citizens without proper family member associations
     * 
     * @return array
     */
    public function findCitizensWithoutFamilyMembers()
    {
        try {
            // Get all citizens
            $citizens = Citizen::query()
                ->with(['familyMembers' => function($query) {
                    $query->whereIn('relationship', ['father', 'mother']);
                }])
                ->get();

            $results = [
                'without_self' => [], // Citizens without a family member with same ID
                'without_spouse' => [], // Citizens with wife_id but no spouse family member
            ];

            foreach ($citizens as $citizen) {
                // Check for self association
                $hasSelfMember = $citizen->familyMembers->contains(function($member) use ($citizen) {
                    return $member->national_id == $citizen->id && 
                           in_array($member->relationship, ['father', 'mother']);
                });

                if (!$hasSelfMember) {
                    $results['without_self'][] = [
                        'citizen' => $citizen,
                        'status' => 'No self association',
                        'details' => 'Citizen ID: ' . $citizen->id . ' has no family member record with same ID'
                    ];
                }

                // Check for spouse association
                if ($citizen->wife_id) {
                    $hasSpouseMember = $citizen->familyMembers->contains(function($member) use ($citizen) {
                        return $member->national_id === $citizen->wife_id && 
                               $member->relationship === 'mother';
                    });

                    if (!$hasSpouseMember) {
                        $results['without_spouse'][] = [
                            'citizen' => $citizen,
                            'status' => 'No spouse association',
                            'details' => 'Citizen has wife_id: ' . $citizen->wife_id . ' but no corresponding family member'
                        ];
                    }
                }
            }

            return $results;
        } catch (Exception $e) {
            Log::error('Error finding citizens without family members', [
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ أثناء البحث عن المواطنين بدون أفراد العائلة');
        }
    }
} 