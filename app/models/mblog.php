<?php

class MBlog extends Eloquent {

    protected $table = 'article';

    public static function getAllCategories($status = 1, $country = 1) {
        $q = "SELECT DISTINCT c.id, c.name, c.nameAr,c.url, (SELECT COUNT(*) FROM article WHERE category=c.id AND status=1) as totalarticles FROM categories c JOIN article a ON a.category=c.id AND a.status=1 WHERE c.status=1 ORDER BY a.createdAt DESC";
        return DB::select(DB::raw($q));
    }

    public static function getCategoryArticles($category = 0, $limit = 10, $offset = 0) {
        $q = "SELECT id,name,nameAr,author,authorAr,image,imageDescription,url,articleType,description,descriptionAr,createdAt FROM article WHERE article.category=:category AND article.status=1 ORDER BY createdAt DESC LIMIT " . $offset . ', ' . $limit;
        return DB::select(DB::raw($q), array('category' => $category));
    }

    public static function getRelatedArticle($article = 0, $category = 0) {
        $q = "SELECT id, name, nameAr, shortDescription, shortDescriptionAr, image, url FROM article WHERE status=1 AND category=:category AND id!=:id ORDER BY createdAt DESC LIMIT 0,5";
        $articles = DB::select(DB::raw($q), array('category' => $category, 'id' => $article));
        if (count($articles) > 0) {
            return $articles;
        } else {
            $q = "SELECT id, name, nameAr, shortDescription, shortDescriptionAr, image, url FROM article WHERE status=1 AND id!=:id ORDER BY createdAt DESC LIMIT 0,5";
            return DB::select(DB::raw($q), array('id' => $article));
        }
    }

    public static function getArticleSlides($article = 0) {
        return DB::table('article_slide')->where('articleID', $article)->where('status', 1)->get();
    }

    public static function getTotalArticles($category = 0) {
        return DB::table('article')->where('category', $category)->where('status', 1)->count();
    }

    public static function getArticleComments($article = 0) {
        return DB::table('articlecomment')->where('articleID', $article)->where('status', 1)->get();
    }

    public static function getArchives() {
        $q = "SELECT MONTHNAME(createdAt) as month,MONTH(createdAt) as m,YEAR(createdAt) as year,COUNT(id) as articles FROM article WHERE status=1  GROUP BY MONTH(createdAt), YEAR(createdAt) ORDER BY createdAt DESC ";
        return DB::select(DB::raw($q));
    }

    public static function updateArticleView($article = 0) {
        DB::table('article')->where('id', $article)->increment('views');
    }

    public static function getAllRecipes($limit = 15, $offset = 0) {
        return DB::table('recipe')->select('id', 'name', 'nameAr', 'description', 'descriptionAr', 'image', 'imageDesc', 'prepTime', 'cookingTime', 'serves', 'authorName', 'authorNameAr', 'createdAt', 'url')->where('status', 1)->orderBy('createdAt', 'DESC')->skip($offset)->take($limit)->get();
    }

    public static function getTotalRecipes() {
        return DB::table('recipe')->where('status', 1)->count();
    }

    public static function getOtherRecipes($recipe = 0) {
        $q = "SELECT id, name, nameAr, image, url FROM recipe WHERE status=1 AND id!=:id ORDER BY createdAt DESC LIMIT 0,5";
        return DB::select(DB::raw($q), array('id' => $recipe));
    }

    public static function getRecipeComments($recipe = 0) {
        return DB::table('recipecomment')->where('recipeID', $recipe)->where('status', 1)->get();
    }

    public static function updateRecipeView($recipe = 0) {
        DB::table('recipe')->where('id', $recipe)->increment('views');
    }

    public static function getRecipeRecommendations($recipe = 0) {
        return DB::table('recipelike')->where('recipeID', $recipe)->count();
    }

    public static function checkUserRecommended($recipe, $user) {
        return DB::table('recipelike')->where('recipeID', $recipe)->where('userID', $user)->count();
    }

    public static function AddUserRecommended($recipe = 0, $user = 0, $country = 1) {
        $ip = Azooma::getRealIpAddr();
        $data = array(
            'recipeID' => $recipe,
            'userID' => $user,
            'ip' => $ip,
            'country' => $country
        );
        DB::table('recipelike')->insert($data);
    }

    public static function RemoveUserRecommended($recipe = 0, $user = 0, $country = 1) {
        DB::table('recipelike')->where('recipeID', $recipe)->where('userID', $user)->where('country', $country)->delete();
    }

    public function getAllCategoriesAdmin($country = 0, $status = "", $main = 0, $name = "", $sort = "") {
        $this->table = "categories";
        $MCats = DB::table('categories');
        $MCats->select('*', DB::Raw('(SELECT count(*) FROM article WHERE article.category=categories.id AND article.status=1) as totalarticles'));
        if (!empty($country)) {
            $MCats->where('categories.country', '=', $country);
        }
        if ($status != "") {
            $MCats->where('categories.status', '=', $status);
        }
        if ($main == '-1') {
            $MCats->where('parent IS NULL');
        } elseif ($main != 0) {
            $MCats->where('parent', $main);
        }
        if (!empty($name)) {
            $MCats->where('name', 'LIKE', "%" . $name . "%");
        }
        if ($sort == "") {
            $MCats->orderBy('categories.position');
        } else {
            switch ($sort) {
                case "latest":
                    $MCats->orderBy('categories.createdAt', 'DESC');
                    break;
                case "name":
                    $MCats->orderBy('categories.name', 'DESC');
                    break;
            }
        }
        $lists = $MCats->paginate();
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getCategory($id, $status = 0) {
        $this->table = "categories";
        $MCategory = MBlog::where('id', $id);
        if ($status == 1) {
            $MCategory = MBlog::where('status', '=', 1);
        }
        $result_Array = $MCategory->first();
        if (count($result_Array) > 0) {
            return $result_Array;
        }
    }

    function getTotalArticlesAdmin($type = 0, $status = 0, $author = "", $month = "", $year = "", $query = "", $titleflag = false) {
        $this->table = "article";
        $MTotalArts = MBlog::select('categories.*');
        if ($type != 0) {
            $MTotalArts->where('category', $type);
        }
        if ($status != 0) {
            $MTotalArts->where('status', 1);
        }
        if ($author != "") {
            $MTotalArts->where('author', $author);
        }
        if ($month != "") {
            $MTotalArts->where('MONTH(createdAt)', $month);
        }
        if ($year != "") {
            $MTotalArts->where('YEAR(createdAt)', $year);
        }
        if ($query != "") {
            $MTotalArts->like('name', $query)->or_like('name', $query);
        }
        if ($titleflag == true) {
            $MTotalArts->where('nameAr', "")->or_where('descriptionAr', "");
        }
        return $MTotalArts->count();
    }

    function addCategory() {
        $this->table = "categories";
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'country' => $country,
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'url' => $url,
            'status' => $status
        );
        return $insertID = DB::table('categories')->insertGetId($data);
    }

    function updateCategory($image = "") {
        $this->table = "categories";
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'country' => $country,
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'url' => $url,
            'status' => $status,
            'lastupdatedArticle' => date('Y-m-d H:i:s')
        );
        DB::table('categories')->where('id', Input::get('id'))->update($data);
    }

    function getArticle($id, $status = 0) {
        $this->table = "article";
        $MArticles = MBlog::where('id', $id);
        if ($status == 1) {
            $MArticles = MBlog::where('status', '=', 1);
        }
        $result_Array = $MArticles->first();
        if (count($result_Array) > 0) {
            return $result_Array;
        }
    }

    function getAllArticle($country = 0, $pid = 0, $status = "", $limit = 0, $name = "", $sort = "", $views = "", $comments = "") {
        $this->table = "article";
        $MArticle = DB::table('article');
        $MArticle->select('*', DB::Raw('(SELECT COUNT(*) FROM articlecomment WHERE articleID=article.id) as totalcomment'), DB::Raw('(SELECT COUNT(*) FROM articlecomment WHERE articleID=article.id AND isRead=0) as new'));
        $MArticle->where('category', '=', $pid);
        if (!empty($country)) {
            $MArticle->where('country', '=', $country);
        }
        if ($status != "") {
            $MArticle->where('status', '=', $status);
        }

        if ($name != "") {
            $MArticle->where('name', 'LIKE', $name . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case "latest":
                    $MArticle->orderBy('createdAt', 'DESC');
                    break;
                case "name":
                    $MArticle->orderBy('name', 'DESC');
                    break;
            }
        }

        if (!empty($views)) {
            if ($views == 1) {
                $MArticle->orderBy('views', 'DESC');
            } else {
                $MArticle->orderBy('views', 'DESC');
            }
        }

        if (!empty($comments)) {
            if ($comments == 1) {
                $MArticle->orderBy('totalcomment', 'DESC');
            } else {
                $MArticle->orderBy('totalcomment', 'DESC');
            }
        }

        if ($sort == "" && $comments == "" && $views == "") {
            $MArticle->orderBy('isFeature', 'DESC');
            $MArticle->orderBy('createdAt', 'DESC');
        }


        if ($limit != "") {
            $lists = $MArticle->paginate($limit);
        } else {
            $lists = $MArticle->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function addArticle($image = "", $broughtbyImage = "") {
        // dd(intval( $_POST['rest_ID']));
        $this->table = "article";
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $locations = "";
        if (isset($_POST['locations'])) {
            $locations = implode(',', $_POST['locations']);
        }
        $tag_rest_ID = "";
        if (isset($_POST['rest_ID'])) {
            $tag_rest_ID = intval(implode(',', $_POST['rest_ID']));
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'shortdescription' => (Input::get('shortdescription')),
            'shortdescriptionAr' => (Input::get('shortdescriptionAr')),
            'description' => htmlentities(Input::get('description')),
            'descriptionAr' => Input::get('descriptionAr'),
            'image' => $image,
            'rest_ID' => $tag_rest_ID,
            'author' => (Input::get('author')),
            'authorAr' => (Input::get('authorAr')),
            'imageDescription' => (Input::get('imageDescription')),
            'category' => (Input::get('category')),
            'locations' => $locations,
            'country' => $country,
            'status' => $status,
            'url' => $url,
            'broughtbyImage' => $broughtbyImage,
            'broughtby' => (Input::get('broughtby')),
            'broughtbyAr' => (Input::get('broughtbyAr')),
            'broughtbyurl' => (Input::get('broughtbyurl'))
        );
        return $id = DB::table('article')->insertGetId($data);
    }

    function updateArticle($image = "", $broughtbyImage = "") {
        $this->table = "article";
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $locations = "";
        if (isset($_POST['locations'])) {
            $locations = implode(',', $_POST['locations']);
        }
        $tag_rest_ID = "";
        if (isset($_POST['rest_ID'])) {
            $tag_rest_ID = intval(implode(',', $_POST['rest_ID']));
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'shortdescription' => (Input::get('shortdescription')),
            'shortdescriptionAr' => (Input::get('shortdescriptionAr')),
            'description' => htmlentities(Input::get('description')),
            'descriptionAr' => Input::get('descriptionAr'),
            'image' => $image,
            'rest_ID' => $tag_rest_ID,
            'author' => (Input::get('author')),
            'authorAr' => (Input::get('authorAr')),
            'imageDescription' => (Input::get('imageDescription')),
            'category' => (Input::get('category')),
            'locations' => $locations,
            'country' => $country,
            'status' => $status,
            'url' => $url,
            'broughtbyImage' => $broughtbyImage,
            'broughtby' => (Input::get('broughtby')),
            'broughtbyAr' => (Input::get('broughtbyAr')),
            'broughtbyurl' => (Input::get('broughtbyurl')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('article')->where('id', Input::get('id'))->update($data);
    }

    function deleteArticle($id) {
        $this->table = "article";
        DB::table('article')->where('id', $id)->delete();
    }

    function getSlideArticle($id = 0, $status = 0) {
        $this->table = "article_slide";
        $MSlideArticles = MBlog::where('id', $id);
        if ($status == 1) {
            $MSlideArticles = MBlog::where('status', '=', 1);
        }
        $result_Array = $MSlideArticles->get();
        if (count($result_Array) > 0) {
            return $result_Array;
        }
    }

    function getSlidesByArticleID($id = 0) {
        $this->table = "article_slide";
        $MSlideArticles = MBlog::where('articleID', $id);
        $result_Array = $MSlideArticles->get();
        if (count($result_Array) > 0) {
            return $result_Array;
        }
    }

    function deleteSlide($id) {
        $this->table = "article_slide";
        DB::table('article_slide')->where('id', $id)->delete();
    }

    function makeFeatureArticle($articleID = 0, $categoryID = 0) {
        $data = array(
            'isFeature' => 0
        );
        DB::table('article')->where('category', '=', $categoryID)->update($data);
        $data = array(
            'isFeature' => 1
        );
        DB::table('article')->where('id', '=', $articleID)->update($data);
    }

    function removeFeatureArticle($articleID = 0, $categoryID = 0) {
        $data = array(
            'isFeature' => 0
        );
        DB::table('article')->where('id', '=', $articleID)->update($data);
    }

    function addSlideArticle($image = "", $i, $articleID, $logo = "") {
        if (isset($_POST['status-' . $i])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $tagRestID = "";
        if (isset($_POST['tagRest-' . $i])) {
            $tagRestID = implode(',', $_POST['tagRest-' . $i]);
        }
        $url = Str::slug((Input::get('slidename-' . $i)), '-');
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('slidename-' . $i)),
            'nameAr' => (Input::get('slideNameAr-' . $i)),
            'description' => htmlentities(Input::get('description-' . $i)),
            'descriptionAr' => Input::get('descriptionAr-' . $i),
            'image' => $image,
            'logo' => $logo,
            'rest_ID' => $tagRestID,
            'category' => (Input::get('category')),
            'articleID' => $articleID,
            'country' => $country,
            'status' => $status,
            'url' => $url
        );
        return $insertID = DB::table('article_slide')->insertGetId($data);
    }

    function updateSlideArticle($image = "", $i, $articleID, $logo = "") {
        if (isset($_POST['status-' . $i])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $tagRestID = "";
        if (isset($_POST['tagRest-' . $i])) {
            $tagRestID = implode(',', $_POST['tagRest-' . $i]);
        }
        $url = Str::slug((Input::get('slidename-' . $i)), '-');
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('slidename-' . $i)),
            'nameAr' => (Input::get('slideNameAr-' . $i)),
            'description' => htmlentities(Input::get('description-' . $i)),
            'descriptionAr' => Input::get('descriptionAr-' . $i),
            'image' => $image,
            'logo' => $logo,
            'rest_ID' => $tagRestID,
            'category' => (Input::get('category')),
            'articleID' => $articleID,
            'country' => $country,
            'status' => $status,
            'url' => $url
        );
        DB::table('article_slide')->where('id', Input::get('id-' . $i))->update($data);
    }

    function addTopSlideArticle($image, $broughtbyImage) {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $locations = "";
        if (isset($_POST['locations'])) {
            $locations = implode(',', $_POST['locations']);
        }
        $url = Str::slug((Input::get('name')), '-');
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'category' => (Input::get('category')),
            'shortdescription' => (Input::get('shortdescription')),
            'shortdescriptionAr' => (Input::get('shortdescriptionAr')),
            'image' => $image,
            'author' => (Input::get('author')),
            'authorAr' => (Input::get('authorAr')),
            'broughtbyImage' => $broughtbyImage,
            'broughtby' => (Input::get('broughtby')),
            'broughtbyAr' => (Input::get('broughtbyAr')),
            'broughtbyurl' => (Input::get('broughtbyurl')),
            'locations' => $locations,
            'country' => $country,
            'status' => $status,
            'articleType' => 1,
            'url' => $url
        );
        return $insertID = DB::table('article')->insertGetId($data);
    }

    function updateTopSlideArticle($id = 0, $image, $broughtbyImage) {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $locations = "";
        if (isset($_POST['locations'])) {
            $locations = implode(',', $_POST['locations']);
        }
        $url = Str::slug((Input::get('name')), '-');
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'shortdescription' => (Input::get('shortdescription')),
            'shortdescriptionAr' => (Input::get('shortdescriptionAr')),
            'category' => (Input::get('category')),
            'image' => $image,
            'author' => (Input::get('author')),
            'authorAr' => (Input::get('authorAr')),
            'broughtbyImage' => $broughtbyImage,
            'broughtby' => (Input::get('broughtby')),
            'broughtbyAr' => (Input::get('broughtbyAr')),
            'broughtbyurl' => (Input::get('broughtbyurl')),
            'locations' => $locations,
            'articleType' => 1,
            'country' => $country,
            'status' => $status,
            'url' => $url
        );
        DB::table('article')->where('id', $id)->update($data);
    }

    function getAllRecipeCategories($status = 1) {
        $this->table = 'recipe';
        $MRecipeCat = MBlog::select('*');
        if ($status == 1) {
            $MRecipeCat->where('recipe.status', 1);
        }
        $MRecipeCat->where('recipe.parent', 0);
        $lists = $MRecipeCat->paginate();
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getAllRecipe($country = 0, $status = "", $sort = "latest", $limit = 0, $main = 0, $name = "", $views = "") {
        $this->table = "recipe";
        $MRecipe = DB::table('recipe');
        if (!empty($country)) {
            $MRecipe->where('recipe.country', $country);
        }
        if ($status != "") {
            $MRecipe->where('recipe.status', '=', $status);
        }

        if ($name != "") {
            $MRecipe->where('recipe.name', 'LIKE', "%".$name . "%");
        }

//        if ($author != "") {
//            $MRecipe->where('recipe.author', $author);
//        }
//        if ($month != "") {
//            $MRecipe->where('MONTH(recipe.createdAt)', $month);
//        }
//        if ($year != "") {
//            $MRecipe->where('YEAR(recipe.createdAt)', $year);
//        }
//        if ($ingredient != "") {
//            $MRecipe->join('ingredients', 'ingredients.recipeID=recipe.id AND ingredients.ingredient="' . $ingredient . '"');
//        }
        if ($main == '-1') {
            $MRecipe->where('recipe.parent IS NULL');
        } elseif ($main != 0) {
            $MRecipe->where('recipe.parent', $main);
        }

        switch ($sort) {
            case "latest":
                $MRecipe->orderBy('recipe.createdAt', 'DESC');
                break;
            case "name":
                $MRecipe->orderBy('recipe.name', 'ASC');
                break;
            case "popularity":
                $MRecipe->orderBy('recipe.views', 'DESC');
                break;
        }
        if ($limit != 0) {
            $lists = $MRecipe->paginate($limit);
        } else {
            $lists = $MRecipe->paginate();
        }

        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getRecipe($id = 0) {
        $this->table = 'recipe';
        $MRecipe = MBlog::select('*');
        $MRecipe->where('id', $id);
        $res = $MRecipe->first();
        if (count($res) > 0) {
            return $res;
        }
        return NULL;
    }

    function getRecipeByUrl($url = "") {
        $this->table = 'recipe';
        $MRecipe = MBlog::select('*');
        $MRecipe->where('url', $url);
        $res = $MRecipe->first();
        if (count($res) > 0) {
            return $res;
        }
        return NULL;
    }

    function addRecipe($image = "") {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $url = Str::slug((Input::get('name')), '-');
        if (count($this->getRecipeByUrl($url)) > 0) {
            $url = $url . rand(1, 10000);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'prepTime' => (Input::get('prepTime')),
            'cookingTime' => (Input::get('cookingTime')),
            'serves' => (Input::get('serves')),
            'image' => $image,
            'imageDesc' => (Input::get('imageDesc')),
            'short' => (Input::get('short')),
            'shortAr' => (Input::get('shortAr')),
            'description' => (Input::get('description')),
            'descriptionAr' => (Input::get('descriptionAr')),
            'video_url' => (Input::get('video_url')),
            'authorName' => (Input::get('authorName')),
            'authorNameAr' => (Input::get('authorNameAr')),
            'country' => $country,
            'status' => $status,
            'url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('recipe')->insertGetId($data);
    }

    function updateRecipe($image = "") {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'prepTime' => (Input::get('prepTime')),
            'cookingTime' => (Input::get('cookingTime')),
            'serves' => (Input::get('serves')),
            'image' => $image,
            'imageDesc' => (Input::get('imageDesc')),
            'short' => (Input::get('short')),
            'shortAr' => (Input::get('shortAr')),
            'description' => htmlentities(Input::get('description')),
            'descriptionAr' => Input::get('descriptionAr'),
            'video_url' => (Input::get('video_url')),
            'authorName' => (Input::get('authorName')),
            'authorNameAr' => (Input::get('authorNameAr')),
            'country' => $country,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('recipe')->where('id', Input::get('id'))->update($data);
    }

    function addIngredient($recipeID = 0, $quantity = "", $ingredient = "", $quantityAr = "", $ingredientAr = "") {
        $data = array(
            'recipeID' => $recipeID,
            'quantity' => ($quantity),
            'quantityAr' => ($quantityAr),
            'ingredient' => ($ingredient),
            'ingredientAr' => ($ingredientAr)
        );
        return DB::table('ingredients')->insertGetId($data);
    }

    function deleteIngredients($id) {
        $this->table = "ingredients";
        DB::table('ingredients')->where('recipeID', $id)->delete();
    }

    function getIngredients($id = 0) {
        $this->table = "ingredients";
        $MIngredients = MBlog::select('*');
        $MIngredients->where('recipeID', $id);
        $rest = $MIngredients->paginate();
        if (count($rest) > 0) {
            return $rest;
        }
        return NULL;
    }

}
