<?php

namespace App\Services;

use App\Models\FamilyMember;
use App\Models\Citizen;
use App\Models\Records\Person;
use App\Models\Records\Relation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;

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

        public function searchRecords( Citizen $citizen)
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

    public function getChildrenRecords(Citizen $citizen){ // return persons fo a family
        $id=$citizen->id;
        $person= Person::find($id);
        if ($person) {
            $childs =  $person->getChilds();
            return $childs;
        }
        return [];

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
} 