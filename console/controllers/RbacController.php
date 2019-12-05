<?php
namespace console\controllers;


use common\components\rbac\UserGroupRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;

        // Create roles
        $guest  = $authManager->createRole('guest');
        $admin  = $authManager->createRole('admin');
        $mentor = $authManager->createRole('mentor');
        $supervisor = $authManager->createRole('supervisor');
        $supermentor = $authManager->createRole('supermentor');
        $student = $authManager->createRole('student');
        $lead = $authManager->createRole('lead');

//        $brand  = $authManager->createRole('BRAND');
//        $talent = $authManager->createRole('TALENT');

        // Create simple, based on action{$NAME} permissions
        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');

        $error  = $authManager->createPermission('error');
        $index  = $authManager->createPermission('index');
        $view   = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');

//        $signUp = $authManager->createPermission('sign-up');


        // Add permissions in Yii::$app->authManager
        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($error);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);

//        $authManager->add($signUp);

        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;
        $student->ruleName  = $userGroupRule->name;
        $lead->ruleName = $userGroupRule->name;
        $mentor->ruleName = $userGroupRule->name;
        $supervisor->ruleName = $userGroupRule->name;
        $supermentor->ruleName = $userGroupRule->name;

//        $brand->ruleName  = $userGroupRule->name;
//        $talent->ruleName = $userGroupRule->name;

        // Add roles in Yii::$app->authManager
        $authManager->add($guest);
        $authManager->add($admin);
        $authManager->add($student);
        $authManager->add($lead);
        $authManager->add($supervisor);
        $authManager->add($mentor);
        $authManager->add($supermentor);

//        $authManager->add($brand);
//        $authManager->add($talent);

        // Add permission-per-role in Yii::$app->authManager
        // Guest
        $authManager->addChild($guest, $login);
        $authManager->addChild($guest, $logout);
        $authManager->addChild($guest, $error);
        $authManager->addChild($guest, $index);
        $authManager->addChild($guest, $view);

        // Lead
        $authManager->addChild($lead,$update);
        $authManager->addChild($lead, $guest);

        // Student
//        $authManager->addChild($guest, $signUp);
//        $authManager->addChild($student, $update);
        $authManager->addChild($student, $lead);


        // Mentor
        $authManager->addChild($mentor, $student);


        // Supervisor
        $authManager->addChild($supervisor,$student);

        // Supermentor
        $authManager->addChild($supermentor,$guest);
        $authManager->addChild($supermentor,$supervisor);
        $authManager->addChild($supermentor,$mentor);

        // Admin
        $authManager->addChild($admin, $delete);
        $authManager->addChild($admin, $supermentor);

//        $authManager->addChild($admin, $talent);
//        $authManager->addChild($admin, $brand);

        // BRAND
//        $authManager->addChild($brand, $update);
//        $authManager->addChild($brand, $guest);
//
//      // TALENT
//        $authManager->addChild($talent, $update);
//        $authManager->addChild($talent, $guest);

    }
}