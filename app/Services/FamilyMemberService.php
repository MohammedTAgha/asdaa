<?php

namespace App\Services;

use App\Models\FamilyMember;
use App\Models\Citizen;
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

    public function addMember(array $data, Citizen $citizen)
    {
        try {
            // Check if member already exists
            $existingMember = $citizen->familyMembers()
                ->where('national_id', $data['national_id'])
                ->first();

            if ($existingMember) {
                throw new Exception('هذا الفرد موجود بالفعل في العائلة');
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