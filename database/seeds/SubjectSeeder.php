<?php

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            ['name' => 'Công nghệ phần mềm'],
            ['name' => 'Hệ thống thông tin'],
            ['name' => 'Khoa học máy tính'],
            ['name' => 'Kỹ thuật máy tính'],
            ['name' => 'Truyền thông mạng máy tính'],
            ['name' => 'Trung tâm máy tính'],
            ['name' => 'Trung tâm đổi mới sáng tạo'],
            ['name' => 'Trung tâm NAVIS'],
            ['name' => 'Trung tâm Cyber Security']
        ]);
    }
}
