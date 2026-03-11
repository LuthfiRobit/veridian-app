<?php

namespace App\Services;

use App\Interfaces\TeamMemberRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TeamMemberService
{
    protected $teamMemberRepository;

    public function __construct(TeamMemberRepositoryInterface $teamMemberRepository)
    {
        $this->teamMemberRepository = $teamMemberRepository;
    }

    public function getAllTeamMembers()
    {
        return $this->teamMemberRepository->getAll();
    }

    public function getTeamMemberById($id)
    {
        return $this->teamMemberRepository->findById($id);
    }

    public function createTeamMember(array $data)
    {
        DB::beginTransaction();
        try {
            // 1. Extract translations
            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            // 2. Handle photo upload
            if (!empty($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
                $data['photo_path'] = $data['photo']->store('team/photos', 'public');
            }
            unset($data['photo']); // Always remove — not a DB column

            // 3. Ensure is_active is a boolean integer
            $data['is_active'] = !empty($data['is_active']) ? 1 : 0;

            // 4. Create main record
            $member = $this->teamMemberRepository->create($data);

            // 5. Save translations via Astrotomic translateOrNew
            foreach ($translations as $locale => $attrs) {
                $member->translateOrNew($locale)->fill($attrs)->save();
            }

            activity()
                ->performedOn($member)
                ->causedBy(auth()->user())
                ->withProperties(['name' => $member->name])
                ->log('Created Team Member');

            DB::commit();
            return $member;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating team member: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function updateTeamMember($id, array $data)
    {
        $member = $this->teamMemberRepository->findById($id);

        DB::beginTransaction();
        try {
            // 1. Extract translations
            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            // 2. Handle photo replacement
            if (!empty($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
                if ($member->photo_path) {
                    Storage::disk('public')->delete($member->photo_path);
                }
                $data['photo_path'] = $data['photo']->store('team/photos', 'public');
            }
            unset($data['photo']); // Always remove — not a DB column

            // 3. Handle photo removal checkbox
            if (!empty($data['remove_photo'])) {
                if ($member->photo_path) {
                    Storage::disk('public')->delete($member->photo_path);
                }
                $data['photo_path'] = null;
            }
            unset($data['remove_photo']); // Not a DB column

            // 4. Update main record
            $this->teamMemberRepository->update($id, $data);

            // 5. Refresh model and save translations
            $updatedMember = $this->teamMemberRepository->findById($id);

            activity()
                ->performedOn($updatedMember)
                ->causedBy(auth()->user())
                ->withProperties(['name' => $updatedMember->name])
                ->log('Updated Team Member');

            DB::commit();
            return $updatedMember;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating team member: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function deleteTeamMember($id)
    {
        $member = $this->teamMemberRepository->findById($id);
        if ($member) {
            if ($member->photo_path) {
                Storage::disk('public')->delete($member->photo_path);
            }
            $deleted = $this->teamMemberRepository->delete($id);

            activity()
                ->performedOn($member)
                ->causedBy(auth()->user())
                ->withProperties(['name' => $member->name])
                ->log('Deleted Team Member');

            return $deleted;
        }
        return false;
    }
}
