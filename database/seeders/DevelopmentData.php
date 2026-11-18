<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DevelopmentData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedFromCSV('article_has_articlecategory.csv', 'ab_article_has_articlecategory');
        //$this->seedTestData();
        //$this->seedFromCSV('user.csv', 'ab_user');
        //$this->seedFromCSV('articles.csv', 'ab_article');
        //$this->seedFromCSV('articlecategory.csv', 'ab_articlecategory');

        // Setzt die Sequenz für die `id`-Spalte zurück
        //DB::statement('SELECT setval(\'ab_user_id_seq\', (SELECT MAX(id) FROM ab_user));');
        // Erstellt 10.000 Benutzer
        //User::factory()->count(10000)->create();
    }

    private function seedTestData(): void {
        DB::table('ab_testdata')->insert([
            ['id' => 1, 'ab_testname' => 'Fotokamera'],
            ['id' => 2, 'ab_testname' => 'Blitzlicht']
        ]);
    }
    private function seedFromCSV($filename, $table): void
    {
        $filepath = storage_path("app/data/{$filename}");

        if (!file_exists($filepath) || !is_readable($filepath)) {
            Log::error("CSV file {$filename} not found or unreadable.");
            return;
        }

        $header = null;
        $data = [];

        if (($fileHandle = fopen($filepath, 'r')) !== false) {
            while (($row = fgetcsv($fileHandle, 1000, ';')) !== false) {
                $row = array_map('trim', $row); // Entferne Leerzeichen

                if(!$header) {
                    $header = $row; // Erste Zeile als Header speichern
                } else {
                    // Konvertierungen
                    foreach ($row as $key => $value) {
                        if ($value === 'NULL' || $value === '') {  // Falls "NULL" oder leerer String, dann echtes NULL
                            $row[$key] = null;
                        } elseif ($header[$key] === 'ab_createdate') {
                            $row[$key] = date('Y-m-d H:i:s', strtotime($value));
                        } elseif ($header[$key] === 'ab_price') {
                            // Preis in Cent umwandeln
                            $row[$key] = (int)str_replace('.', '', $value) * 100;
                        }
                    }
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($fileHandle);
        }

        if (!empty($data)) {
            DB::table($table)->truncate(); // Leert die Tabelle vor dem Einfügen
            DB::table($table)->insert($data);
        }
    }

    private function seedAddRandomlyUser($from,$to): void {
        for ($i = $from; $i <= $to; $i++) {
            $id = $i;
            // Zufälliger Benutzername basierend auf "Visitor" oder "Seller"
            $randomUser = rand(0, 1) ? 'Visitor' : 'Seller';
            $name = $randomUser . $i;

            // Passwort und E-Mail
            $password = $name;
            $email = $name . '@abalo.example.com';
            DB::table('ab_user')->insert([
                'id' => $id,
                'ab_name' => $name,
                'ab_password' => $password,
                'ab_mail' => $email,
            ]);
        }
    }
}
