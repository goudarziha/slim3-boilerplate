<?php
namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'name',
        'password',
        'admin',
        'last_seen'
    ];

    public function setPassword($password)
    {
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function setAdmin()
    {
        $this->update([
            'admin' => "1"
        ]);
    }

    public function gravatar($email = '', $size = '')
    {
        $default = "https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50"; // Set a Default Avatar
        $email = md5(strtolower(trim($email)));
        $gravurl = "http://www.gravatar.com/avatar/" . $email . "?s=" . $size . "&d=identicon&r=PG";
        return '<img src="' . $gravurl . '" width="' . $size . '" height="' . $size . '" border="0" alt="Avatar">';
    }

    public function updateLastTime()
    {
        $this->update([
            'last_seen' => Carbon::now()
        ]);
    }
}

?>