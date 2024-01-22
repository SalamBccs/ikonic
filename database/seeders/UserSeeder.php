<?php

namespace Database\Seeders;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Feedback;
use App\Models\Comment;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $operator1 = User::create([
            'username' => 'Operator1',
            'email' => 'Operator1@gmail.com',
            'password' => Hash::make('Operator123'),
        ]);

        Operator::create(['operator_id' => $operator1->id]);

        $abdus = User::create([
            'username' => 'Abdus Salam',
            'email' => 'salamdeveloperbcs@gmail.com',
            'password' => Hash::make('salam123'),
        ]);

        $role1 = Role::find(1);
        $abdus->assignRole($role1->name);

        $role2 = Role::find(2);
        $operator1->assignRole($role2->name);

        $role3 = Role::find(3);
        $admin->assignRole($role3->name);
       
       
        $feedback = Feedback::create([
            'username' => $admin->username,
            'title' => 'Web',
            'description' => 'Development',
            'category' => 'bug',
        ]);
        $comment = Comment::create([
            'feedback_id' => $feedback->id,
            'username' => $abdus->username,
            'content' => 'For Testing purpose',
        ]);
    
    }


}
