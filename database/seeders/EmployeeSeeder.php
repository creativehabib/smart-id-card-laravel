<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employees')->insert([
            [
              'name'=>'Habibur Rahaman',
              'designation'=>'Administrative Officer',
              'department'=>'Office of the College Inspection',
              'pf_no'=>'2125','mobile'=>'01914120688','blood_group'=>'O (+Ve)',
              'address'=>'Azampur, Uttara, Dhaka','emergency_contact'=>'01627582568',
              'valid_to'=>Carbon::parse('2044-01-04'),
              'photo_path'=>null,'photo_bg'=>'#e9f2ff',
              'qr_payload'=>json_encode(['pf_no'=>'2125','mobile'=>'01914120688']),
              'created_at'=>now(),'updated_at'=>now(),
            ],
            [
              'name'=>'Rahim Uddin','designation'=>'Assistant Programmer','department'=>'ICT Cell',
              'pf_no'=>'3182','mobile'=>'01700000000','blood_group'=>'A (+Ve)',
              'address'=>'Gazipur, Bangladesh','emergency_contact'=>'01811111111',
              'valid_to'=>Carbon::now()->addYears(10),
              'photo_path'=>null,'photo_bg'=>'#fff2e9',
              'qr_payload'=>json_encode(['pf_no'=>'3182']),
              'created_at'=>now(),'updated_at'=>now(),
            ],
            [
              'name'=>'Sadia Khatun','designation'=>'Lecturer','department'=>'Public Health',
              'pf_no'=>'4277','mobile'=>'01620000000','blood_group'=>'B (+Ve)',
              'address'=>'Dhaka, Bangladesh','emergency_contact'=>'01620000001',
              'valid_to'=>Carbon::now()->addYears(8),
              'photo_path'=>null,'photo_bg'=>'#f3ffe9',
              'qr_payload'=>json_encode(['pf_no'=>'4277']),
              'created_at'=>now(),'updated_at'=>now(),
            ],
            [
              'name'=>'Anisur Rahman','designation'=>'Lab Assistant','department'=>'Microbiology',
              'pf_no'=>'5120','mobile'=>'01530000000','blood_group'=>'AB (+Ve)',
              'address'=>'Chittagong, Bangladesh','emergency_contact'=>'01530000001',
              'valid_to'=>Carbon::now()->addYears(5),
              'photo_path'=>null,'photo_bg'=>'#ffe9f3',
              'qr_payload'=>json_encode(['pf_no'=>'5120']),
              'created_at'=>now(),'updated_at'=>now(),
            ],
            [
              'name'=>'Fatema Begum','designation'=>'Senior Staff Nurse','department'=>'Health Center',
              'pf_no'=>'6231','mobile'=>'01440000000','blood_group'=>'O (-Ve)',
              'address'=>'Sylhet, Bangladesh','emergency_contact'=>'01440000001',
              'valid_to'=>Carbon::now()->addYears(7),
              'photo_path'=>null,'photo_bg'=>'#e9f2ff',
              'qr_payload'=>json_encode(['pf_no'=>'6231']),
              'created_at'=>now(),'updated_at'=>now(),
            ],
            [
                'name'=>'Jamal Uddin','designation'=>'Security Officer','department'=>'Security Unit',
                'pf_no'=>'7345','mobile'=>'01350000000','blood_group'=>'A (-Ve)',
                'address'=>'Khulna, Bangladesh','emergency_contact'=>'01350000001',
                'valid_to'=>Carbon::now()->addYears(6),
                'photo_path'=>null,'photo_bg'=>'#fff2e9',
                'qr_payload'=>json_encode(['pf_no'=>'7345']),
                'created_at'=>now(),'updated_at'=>now(),
            ],
            [
                'name'=>'Laila Akter','designation'=>'Accountant','department'=>'Finance Department',
                'pf_no'=>'8456','mobile'=>'01260000000','blood_group'=>'B (-Ve)',
                'address'=>'Barisal, Bangladesh','emergency_contact'=>'01260000001',
                'valid_to'=>Carbon::now()->addYears(9),
                'photo_path'=>null,'photo_bg'=>'#f3ffe9',
                'qr_payload'=>json_encode(['pf_no'=>'8456']),
                'created_at'=>now(),'updated_at'=>now(),
            ],
            [
                'name'=>'Monir Hossain','designation'=>'Driver','department'=>'Transport Section',
                'pf_no'=>'9567','mobile'=>'01170000000','blood_group'=>'AB (-Ve)',
                'address'=>'Rangpur, Bangladesh','emergency_contact'=>'01170000001',
                'valid_to'=>Carbon::now()->addYears(4),
                'photo_path'=>null,'photo_bg'=>'#ffe9f3',
                'qr_payload'=>json_encode(['pf_no'=>'9567']),
                'created_at'=>now(),'updated_at'=>now(),
            ],
            [
                'name'=>'Nabila Sultana','designation'=>'Cleaner','department'=>'Maintenance',
                'pf_no'=>'1078','mobile'=>'01080000000','blood_group'=>'O (+Ve)',
                'address'=>'Mymensingh, Bangladesh','emergency_contact'=>'01080000001',
                'valid_to'=>Carbon::now()->addYears(3),
                'photo_path'=>null,'photo_bg'=>'#e9f2ff',
                'qr_payload'=>json_encode(['pf_no'=>'1078']),
                'created_at'=>now(),'updated_at'=>now(),
            ],
        ]);
    }
}
