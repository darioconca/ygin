<?php

class NewsController extends Controller
{

    protected $urlAlias = "news";

    /**
     * Список новостей
     */
    public function actionIndex($idCategory = null)
    {
        $criteria = new CDbCriteria();
        $newsModule = $this->getModule();
        $category = null;
        $categories = array();
        //Если включено отображение категорий
        if ($newsModule->showCategories) {
            if ($idCategory !== null && $category = $this->loadModelOr404('NewsCategory', $idCategory)) {
                $criteria->compare('t.id_news_category', $idCategory);
            }
            $categories = NewsCategory::model()->findAll(array(
                'order' => 'seq',
            ));
        }

        $news = News::model()
            ->last()
            ->findAll($criteria);

        $pages = new CPagination(count($news));
        $pages->pageSize = $newsModule->itemsCountPerPage;
        $pages->applyLimit($criteria);

        $this->render('/index', array(
            'news' => $news,  // список новостей
            'pages' => $pages,  // пагинатор
            'category' => $category,  // текущая категория
            'categories' => $categories,  // все категории
        ));
    }

    /**
     * Одиночная новость
     * @param int $id
     */
    public function actionView($id)
    {

        $news = $this->loadModelOr404('News', $id);

        if ( $image = $news->image ){
            Yii::app()->clientScript->registerMetaTag($image->getUrl(true),'og:image');
        }

        $this->caption = $news->title;
        $this->render('/view', array(
            'model' => $news,
        ));
    }

}