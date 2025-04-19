<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    public function dataSetting()
    {
        return $this->db->table('tbl_setting')
        ->where('id_setting', 1)->get()->getRowArray();
    }

    public function updateSetting($data)
    {
        $this->db->table('tbl_setting')
        ->where('id_setting', 1)
        ->update($data);
    }
}
