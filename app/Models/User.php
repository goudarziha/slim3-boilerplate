<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class User extends Model {
        protected $table = 'users';

        protected $fillable = [
            'email',
            'name',
            'password',
            'admin'
        ];

        public function setPassword($password) {
            $this->update([
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
        }

        public function setAdmin() {
            $this->update([
                'admin' => "1"
            ]);
        }
    }
    
?>