<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // CSVファイルのパス
         $csvFilePath = database_path('seeders/common/users.csv');

        // ファイルを開いて内容を読み込む
        if (!file_exists($csvFilePath)) {
            $this->command->error("CSV file not found at $csvFilePath");
            return;
        }

        // CSVファイルを読み込み
        $data = array_map('str_getcsv', file($csvFilePath));
        $header = array_shift($data); // ヘッダーを取得

        foreach ($data as $row) {
            $rowData = array_combine($header, $row); // ヘッダーとデータを結合

            DB::table('users')->insert([
                'name' => $rowData['name'],
                'email' => $rowData['email'],
                'password' => Hash::make($rowData['password']), // パスワードをハッシュ化
                'email_verified_at' => $rowData['email_verified_at'] ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
