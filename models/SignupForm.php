<?php
 
namespace app\models;
 
use Yii;
use yii\base\Model;
 
/**
 * Signup form
 */
class SignupForm extends Model
{
 
    public $username;
    public $email;
    public $password;
    public $partner_id;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ///['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['partner_id', 'trim'],
            ['partner_id', 'required'],
            ['partner_id', 'string', 'min' => 10, 'max' => 10],
            ///['partner_id', 'validatePartner'],
           /// ['partner_id', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This partner_id has already been taken.'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function validatePartner($attribute, $params){
        if(count($this->$attribute) < 10){
            $this->addError($attribute, 'Partner_id меньше 10 символов');
        }
    }
 
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
 
        $user = new User();
        $user->username = $this->username;
        $user->partner_id = $user->generatePartnerId();
        //var_dump($user->username);
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
 
}