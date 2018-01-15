<?php

class ApiController extends Controller
{
    public function actionLogin($login = NULL, $password = NULL)
    {
        if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
            $this->answer(array("result" => "error", "message" => "Ошибка сервера"));

        $model=new LoginForm;

        if( $login === NULL || $password === NULL || $login == "" || $password == "" )
            $this->answer(array("result" => "error", "message" => "Не указан логин или пароль"));

        $model->attributes = array("username" => $login, "password" => $password);

        if($model->validate() && $model->login()){
            $user = User::model()->with("role")->find("login='$login'");
            $user->prevPass = $user->password;
            $user->prevRole = $user->role->code;
            $user->token = md5(time()."Olololo".rand());
            $user->save();

            $this->answer(array("result" => "success", "user" => array("id" => $user->id, "login" => $user->login, "name" => $user->name, "email" => $user->email, "role" => $user->role->code, "token" => $user->token)));
        }else{
            $this->answer(array("result" => "error", "message" => "Неправильная пара логин-пароль"));
        }
    }

// Проекты ------------------------------------------------------------------- Проекты
    public function actionProjects()
    {
        $user = $this->auth();

        $projects = Project::model()->with(array("users","domain","city","words.word"))->findAll(array( "condition" => "users.user_id=".$user->id ));
        $out = array();

        $out = array();
        foreach ($projects as $i => $project) {
            $words = $this->getWords($project);

            $tmp = $this->getProject($project, $words);

            $out[intval($project->id)] = $tmp;
        }

        $this->answer(array("result" => "success", "projects" => $out));
    }

    public function actionCreateProject()
    {
        $user = $this->auth();

        if( $city = City::model()->find("name='".$_POST["city"]."'") ){
            $attributes = array(
                "name" => $_POST["name"],
                "domain_id" => $_POST["domain"],
                "city_id" => $city->id,
            );
            if( Project::create($attributes, $user->id) ){
                $this->actionProjects();
            }else $this->answer(array("result" => "error", "message" => "Не удалось создать сайт"));
        }else $this->answer(array("result" => "error", "message" => "Город не существует"));
    }

    public function actionUpdateProject()
    {
        $user = $this->auth();

        if( isset($_POST["name"]) && isset($_POST["id"]) && $project = Project::model()->findByPk($_POST["id"]) ){
            $project->name = $_POST["name"];
            if( $project->save() ){
                $this->actionProjects();
            }else $this->answer(array("result" => "error", "message" => "Не удалось изменить сайт"));
        }else $this->answer(array("result" => "error", "message" => "Сайта не существует"));
    }

    public function actionDeleteProject()
    {
        $user = $this->auth();

        if( isset($_GET["id"]) ){
            if( $project = Project::model()->findByPk($_GET["id"]) ){
                $project->delete();

                $this->answer(array("result" => "success", "id" => $_GET["id"]));
            }else $this->answer(array("result" => "error", "message" => "Сайт уже был удален"));
        }else $this->answer(array("result" => "error", "message" => "Не передан параметр 'id'"));
    }

    public function actionProject(){
        $user = $this->auth();

        $id = $this->getVar("id");

        if( $project = Project::model()->with(array("words.word" => array("order" => "word.value ASC")))->find(array("condition" => "t.id='".$id."'")) ){
            $words = $this->getWords($project);

            $project = $this->getProject($project, $words);
            $this->answer(array("result" => "success", "project" => $project ));
        }else $this->answer(array("result" => "error", "message" => "Сайта не существует"));
    }
// Проекты ------------------------------------------------------------------- Проекты

// Фразы --------------------------------------------------------------------- Фразы
    public function actionAddWords(){
        $user = $this->auth();

        if( isset($_POST["words"]) && isset($_POST["id"]) && Project::model()->count("id='".$_POST["id"]."'") ){
            Word::createAll($_POST["id"], explode(PHP_EOL, $_POST["words"]));
            $this->actionProject();
        }else $this->answer(array("result" => "error", "message" => "Сайта не существует"));
    }

    public function actionDeleteWord(){
        $user = $this->auth();

        $word_id = $this->getVar("word_id");
        $project_id = $this->getVar("project_id");
        if( $model = ProjectWord::model()->with("project")->find("word_id='".$word_id."' AND project_id='".$project_id."'") ){
            $model->delete();
            $this->answer(array("result" => "success", "word_id" => $word_id, "project_id" => $project_id));
        }else $this->answer(array("result" => "error", "project_id" => $project_id, "message" => "Фраза уже была удалена"));
    }

    public function actionWordsLive(){
        $user = $this->auth();

        $project_id = $this->getVar("project_id");
        $words = trim($this->getVar("words"));

        if( $words != "" ){
            if( $words = Word::model()->findAll("id IN (".$words.")") ){
                $out = array();
                Position::getPositions($project_id, $words);
                foreach ($words as $key => $word)
                    if( $word->positions->yandex != 0 )
                        $out[intval($word->id)] = $this->getWord($word);

                $this->answer(array("result" => "success", "project_id" => $project_id, "words" => $out));
            }else $this->answer(array("result" => "warning", "message" => "Слова не найдены"));
        }else $this->answer(array("result" => "error", "message" => "Слова не переданы"));
    }

    public function actionWordDetail(){
        $user = $this->auth();

        $project_id = $this->getVar("project_id");
        $word_id = trim($this->getVar("word_id"));

        if( $word = Word::model()->with("projects")->find("t.id='$word_id' AND projects.project_id='$project_id'") ){
            $word->getInfo($project_id);
            $this->answer(array("result" => "success", "project_id" => $project_id, "word" => $this->getFullWord($word) ));
        }else $this->answer(array("result" => "error", "message" => "Слово не найдено"));
    }
// Фразы --------------------------------------------------------------------- Фразы

    public function getProject($project, $words){
        $out = array(
            "id" => $project->id,
            "name" => $project->name,
            "domain" => $project->domain->value,
            "city" => $project->city->name,
            "words" => $words
        );
        if( $project->domain->image && $project->domain->image != "" )
            $out["image"] = "http://".$_SERVER["HTTP_HOST"]."/".$project->domain->image;

        if( $project->domain->color && $project->domain->color != "" )
            $out["color"] = $project->domain->color;

        return $out;
    }

    public function getWords($project){
        $project->getPositions();
        $out = array();
        foreach ($project->words as $j => $word)
            $out[$word->word->id] = $this->getWord($word->word);
        return $out;
    }

    public function getWord($word){
        return array(
            "id" => $word->id,
            "value" => $word->value,
            "position" => $word->positions->yandex->number
        );
    }

    public function getFullWord($word){
        return array(
            "id" => $word->id,
            "value" => $word->value,
            "position" => ($word->positions)?$word->positions->yandex->number:null,
            "date" => $this->getRusDate($word->last_update),
            "time" => $this->getTime($word->last_update),
            "title" => ($word->positions)?$word->positions->yandex->title:null,
            "link" => ($word->positions)?$word->positions->yandex->link:null,
            "description" => ($word->positions)?$word->positions->yandex->description:null,
        );
    }

    public function getVar($key){
        if( isset($_GET[$key]) ){
            return $_GET[$key];
        }else if( isset($_POST[$key]) ){
            return $_POST[$key];
        }else $this->answer(array("result" => "error", "message" => "Параметр \"$key\" не передан"));
    }

    public function answer($array){
        header("Access-Control-Allow-Origin: *");

        echo json_encode($array);
        die();
    }

    public function auth($token = null){
        return User::model()->findByPk(1);
        if( isset($_POST["token"]) ) $token = $_POST["token"];
        if( isset($_GET["token"]) ) $token = $_GET["token"];

        if( $token === NULL ) $this->answer(array("result" => "error", "message" => "Не указан токен"));

        if( $model = User::model()->find("token='$token'") ){
            return $model;
        }else{
            $this->answer(array("result" => "not_authorized"));
        }
    }
}
