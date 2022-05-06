<?php
class BlogController extends BaseController {

	public function __construct(){
		
	}

	public function index($category=""){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		if($category==""){
			$data['categories']=MBlog::getAllCategories(1);
			$data['meta']=array(
				'title'=>Lang::get('messages.blog').' - '. Lang::get('title.blog'),
				'metadesc'=>Lang::get('metadesc.blog'),
				'metakey'=>Lang::get('metakey.blog'),
			);
			return View::make('blog.home',$data);
		}else{
			$limit=15;$offset=0;$page=1;
			if(Input::has('page')){
				$offset=$limit*(Input::get('page')-1);
				$page=Input::get('page');
			}
			$category=DB::table('categories')->where('url',$category)->first();
			if(count($category)>0){
				$data['total']=MBlog::getTotalArticles($category->id);
				$data['articles']=MBlog::getCategoryArticles($category->id,$limit,$offset);
				$data['category']=$category;
				$categoryname=($lang=="en")?stripcslashes($category->name):stripcslashes($category->nameAr);
				$data['meta']=array(
					'title'=>$categoryname.' '.Lang::get('messages.blog'),
					'metadesc'=>$categoryname.' '.Lang::get('messages.blog'),
					'metakey'=>$categoryname.', '.Lang::get('messages.blog'),
				);
				$data['var']=array(
					'limit'=>$limit,
				);
				$data['paginator']=Paginator::make($data['articles'],$data['total'],$limit);
				$data['originallink']=Azooma::URL('blog/'.$category->url);
				if($page>1){
					$prev=$page-1;
					$data['prev']=Azooma::URL('blog/'.$category->url.'?page='.$prev);
				}
				if(($offset+$limit)<$data['total']){
					$next=$page+1;
					$data['next']=Azooma::URL('blog/'.$category->url.'?page='.$next);
				}
				return View::make('blog.category',$data);	
			}else{
				App::abort(404);
			}
		}
	}


	public function article($url=""){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		if($url!=""){
			$article=DB::table('article')->where('url',$url)->where('status',1)->first();
			if(count($article)>0){
				$data['article']=$article;
				$data['category']=DB::table('categories')->where('id',$article->category)->where('status',1)->first();
				$articletitle=($lang=="en")?stripcslashes($article->name):stripcslashes($article->nameAr);
				$data['articletitle']=$articletitle;
				$data['related']=MBlog::getRelatedArticle($article->id,$article->category);
				$data['comments']=MBlog::getArticleComments($article->id);
				$data['archives']=MBlog::getArchives();
				$data['meta']=array(
					'title'=>$articletitle,
					'metadesc'=>($lang=="en")?stripcslashes($article->shortdescription):stripcslashes($article->shortdescriptionAr),
					'metakey'=>$articletitle,
				);
				if($article->articleType!=0){
					$data['slides']=MBlog::getArticleSlides($article->id);
					return View::make('blog.slide_article',$data);	
				}else{
					return View::make('blog.article',$data);	
				}
				
			}
		}
	}


	public function recipes($url=""){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		if($url==""){
			$limit=15;$offset=0;$page=1;
			if(Input::has('page')){
				$offset=$limit*(Input::get('page')-1);
				$page=Input::get('page');
			}
			$data['meta']=array(
				'title'=>Lang::get('messages.azooma_recipes'),
			);
			$data['recipes']=MBlog::getAllRecipes($limit,$offset);
			$data['total']=MBlog::getTotalRecipes();
			$data['var']=array(
				'limit'=>$limit,
			);
			$data['paginator']=Paginator::make($data['recipes'],$data['total'],$limit);
			$data['originallink']=Azooma::URL('recipes');
			if($page>1){
				$prev=$page-1;
				$data['prev']=Azooma::URL('recipes?page='.$prev);
			}
			if(($offset+$limit)<$data['total']){
				$next=$page+1;
				$data['next']=Azooma::URL('recipes?page='.$next);
			}
			return View::make('blog.recipe_home',$data);
		}else{
			$data['recipe']=DB::table('recipe')->where('url',$url)->where('status',1)->first();
			MBlog::updateRecipeView($data['recipe']->id);
			$data['ingredients']=DB::table('ingredients')->where('recipeID',$data['recipe']->id)->orderBy('createdAt','DESC')->get();
			$data['recommendations']=MBlog::getRecipeRecommendations($data['recipe']->id);
			if(Session::has('userid')){
				$data['userrecommended']=MBlog::checkUserRecommended($data['recipe']->id,Session::get('userid'));
			}
			$data['comments']=MBlog::getRecipeComments($data['recipe']->id);
			$data['related']=MBlog::getOtherRecipes($data['recipe']->id);
			$title=($lang=="en")?stripcslashes($data['recipe']->name):stripcslashes($data['recipe']->nameAr);
				$data['recipetitle']=$title;
			$data['meta']=array(
					'title'=>$title,
				);
				return View::make('blog.recipe',$data);	
		}
	}
}