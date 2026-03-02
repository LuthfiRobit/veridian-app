<?php

namespace App\Interfaces;

interface ProjectRepositoryInterface
{
    public function getAllProjects();
    public function getProjectById($id);
    public function createProject(array $data);
    public function updateProject($id, array $data);
    public function deleteProject($id);
}
