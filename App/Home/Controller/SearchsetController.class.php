<?php
namespace Home\Controller;
use Think\Controller;
use Think\Think;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/8
 * Time: 9:54
 */
class SearchsetController extends Controller{

    public function index(){
        $bookpromote = D('BooktuiView');
        $arr = $bookpromote->where(array('promote_id' => 3))->field('book_name,book_id')->limit(6)->order('xu asc')->select();


        $this->assign('hots', $arr);

        $this->like();

        $this->display();
    }

    //猜你喜欢
    public function like(){

        $bookpromote = D('BooktuiView');
        $likeArr = $bookpromote->where(array('promote_id' => 5))->limit(5)->order('xu asc')->select();


        $this->assign('likeArr', $likeArr);



    }

    public function searched($current=1)
    {
        $keyword = $_POST['keyword'];
        $searchby = $_POST['searchby'];
        if($searchby==1){
            //按书查找
            if($keyword==""){
                $bookpromote = D('BooktuiView');
                $arr = $bookpromote->where(array('promote_id' => 3))->field('book_name,book_id')->limit(6)->order('xu asc')->select();
                $bookpromote = D('BooktuiView');
                $likeArr = $bookpromote->where(array('promote_id' => 5))->limit(5)->order('xu asc')->select();

echo "<div class=\"wrap-content-title\">
	<div>共有0条记录</div>
</div>
<div class=\"hot-book-title\">
	热门书籍
</div>
<ul class=\"hot-list-label\">";

foreach ($arr as $vo){
    echo "<a href=\"/books/$vo[book_id].html\"><li>$vo[book_name]</li></a>";
}
echo "</ul>

<div class=\"wrap-content\">
	<div class=\"wrap-content-title\">
		<div>猜你喜欢</div>
	</div>
	<ul class=\"like-list\">";

        foreach ($likeArr as $vo){

            echo "<li>
			<a href='/books/$vo[book_id].html'><img src=\"/Upload/Book/zhong/$vo[upload_img]\"/></a>
			<p>
				$vo[book_name]
			</p>
		</li>";
        }
	echo "</ul>
</div>";
                exit();
            }
            //分页变量
            $pageSize = 10;//每页显示的记录数
            $totalRow = 0;//总记录数
            $totalPage = 0;//总页数
            $start = ($current-1)*$pageSize;//每页记录的起始值


            $con['book_name'] = array('like', "%$keyword%");
            $book = D('ListView');
            $con['is_show'] = 1;
            $totalRow =$book->where($con)->count();
            $totalPage =ceil($totalRow/$pageSize);
            if($totalPage==0){

                $bookpromote = D('BooktuiView');
                $arr = $bookpromote->where(array('promote_id' => 3))->field('book_name,book_id')->limit(6)->order('xu asc')->select();
                $bookpromote = D('BooktuiView');
                $likeArr = $bookpromote->where(array('promote_id' => 5))->limit(5)->order('xu asc')->select();

                echo "<div class=\"wrap-content-title\">
	<div>共有0条记录</div>
</div>
<div class=\"hot-book-title\">
	热门书籍
</div>
<ul class=\"hot-list-label\">";

                foreach ($arr as $vo){
                    echo "<a href=\"/books/$vo[book_id].html\"><li>$vo[book_name]</li></a>";
                }
                echo "</ul>

<div class=\"wrap-content\">
	<div class=\"wrap-content-title\">
		<div>猜你喜欢</div>
	</div>
	<ul class=\"like-list\">";

                foreach ($likeArr as $vo){

                    echo "<li>
			<a href='/books/$vo[book_id].html'><img src=\"/Upload/Book/zhong/$vo[upload_img]\"/></a>
			<p>
				$vo[book_name]
			</p>
		</li>";
                }
                echo "</ul>
</div>";
                exit();
            }

            $list = $book->where($con)->limit($start,$pageSize)->select();

           echo "<div class=\"wrap-content\">
    <div class=\"wrap-content-title\">
        <div>共有 $totalRow 条记录</div>
    </div>

    <ul class=\"result-set\">";

           foreach ($list as $vo){

               echo "<li class=\"result-set-item\">
                <div class=\"result-set-item-top\">
                    <a href='/books/$vo[book_id].html'><img src=\"/Upload/Book/zhong/$vo[upload_img]\" class=\"searchset-img\"/></a>
                    <a href='/books/$vo[book_id].html'><dl>
                        <dd class=\"result-set-title\">$vo[book_name]</dd>
                        <dd class=\"result-set-auther\">作者：<span>$vo[author_name]</span></dd>
                        <dd class=\"result-set-date\">最后更新时间：$vo[time]</dd>
                    </dl></a>
                </div>
                <div class=\"result-set-item-content\">
                    $vo[book_brief]...
                </div>
            </li>";
           }

    echo "</ul>";

echo "</div>
<div class=\"pager\">";

if($totalRow>10){

    if($current==1){
        echo " <a class=\"pager-item\" href=\"javascript:pages();\">下一页</a>";

    }else{
        echo "<a class=\"pager-item\" href=\"javascript:pagess();\">上一页</a>
            <a class=\"pager-item\" href=\"javascript:pages();\">下一页</a>";
    }
    echo "<div class=\"pager-item\">到</div>
        <div class=\"pager-item page-num-input\"><input type=\"text\" id=\"jump\" value=\"\"/></div>
        <div class=\"pager-item\">页</div>
        <a href=\"javascript:jump();\"><div class=\"pager-item goto\" style=\"margin-left: 2px;\">跳转</div></a>
        <div class=\"pager-item\">$current/$totalPage</div>
        <input type=\"hidden\" id=\"current\" value=\"$current\">
        <input type=\"hidden\" id=\"keyword\" value=\"$keyword\">";
}

echo "</div>";

        }

        if($searchby==2){
            //按作者查找

            if($keyword==""){
                $bookpromote = D('BooktuiView');
                $arr = $bookpromote->where(array('promote_id' => 3))->field('book_name,book_id')->limit(6)->order('xu asc')->select();
                $bookpromote = D('BooktuiView');
                $likeArr = $bookpromote->where(array('promote_id' => 5))->limit(5)->order('xu asc')->select();

                echo "<div class=\"wrap-content-title\">
	<div>共有0条记录</div>
</div>
<div class=\"hot-book-title\">
	热门书籍
</div>
<ul class=\"hot-list-label\">";

                foreach ($arr as $vo){
                    echo "<a href=\"/books/$vo[book_id].html\"><li>$vo[book_name]</li></a>";
                }
                echo "</ul>

<div class=\"wrap-content\">
	<div class=\"wrap-content-title\">
		<div>猜你喜欢</div>
	</div>
	<ul class=\"like-list\">";

                foreach ($likeArr as $vo){

                    echo "<li>
			<a href='/books/$vo[book_id].html'><img src=\"/Upload/Book/zhong/$vo[upload_img]\"/></a>
			<p>
				$vo[book_name]
			</p>
		</li>";
                }
                echo "</ul>
</div>";
                exit();
            }
            //分页变量
            $pageSize = 10;//每页显示的记录数
            $totalRow = 0;//总记录数
            $totalPage = 0;//总页数
            $start = ($current-1)*$pageSize;//每页记录的起始值


            $con['author_name'] = array('like', "%$keyword%");
            $book = D('ListView');
            $con['is_show'] = 1;
            $totalRow =$book->where($con)->count();
            $totalPage =ceil($totalRow/$pageSize);
            if($totalPage==0){

                $bookpromote = D('BooktuiView');
                $arr = $bookpromote->where(array('promote_id' => 3))->field('book_name,book_id')->limit(6)->order('xu asc')->select();
                $bookpromote = D('BooktuiView');
                $likeArr = $bookpromote->where(array('promote_id' => 5))->limit(5)->order('xu asc')->select();

                echo "<div class=\"wrap-content-title\">
	<div>共有0条记录</div>
</div>
<div class=\"hot-book-title\">
	热门书籍
</div>
<ul class=\"hot-list-label\">";

                foreach ($arr as $vo){
                    echo "<a href=\"/books/$vo[book_id].html\"><li>$vo[book_name]</li></a>";
                }
                echo "</ul>

<div class=\"wrap-content\">
	<div class=\"wrap-content-title\">
		<div>猜你喜欢</div>
	</div>
	<ul class=\"like-list\">";

                foreach ($likeArr as $vo){

                    echo "<li>
			<a href='/books/$vo[book_id].html'><img src=\"/Upload/Book/zhong/$vo[upload_img]\"/></a>
			<p>
				$vo[book_name]
			</p>
		</li>";
                }
                echo "</ul>
</div>";
                exit();
            }

            $list = $book->where($con)->limit($start,$pageSize)->select();

            echo "<div class=\"wrap-content\">
    <div class=\"wrap-content-title\">
        <div>共有 $totalRow 条记录</div>
    </div>

    <ul class=\"result-set\">";

            foreach ($list as $vo){

                echo "<li class=\"result-set-item\">
                <div class=\"result-set-item-top\">
                    <a href='/books/$vo[book_id].html'><img src=\"/Upload/Book/zhong/$vo[upload_img]\" class=\"searchset-img\"/></a>
                    <a href='/books/$vo[book_id].html'><dl>
                        <dd class=\"result-set-title\">$vo[book_name]</dd>
                        <dd class=\"result-set-auther\">作者：<span>$vo[author_name]</span></dd>
                        <dd class=\"result-set-date\">最后更新时间：$vo[time]</dd>
                    </dl></a>
                </div>
                <div class=\"result-set-item-content\">
                    $vo[book_brief]...
                </div>
            </li>";
            }

            echo "</ul>";

            echo "</div>
<div class=\"pager\">";

            if($totalRow>10){

                if($current==1){
                    echo " <a class=\"pager-item\" href=\"javascript:pages();\">下一页</a>";

                }else{
                    echo "<a class=\"pager-item\" href=\"javascript:pagess();\">上一页</a>
            <a class=\"pager-item\" href=\"javascript:pages();\">下一页</a>";
                }
                echo "<div class=\"pager-item\">到</div>
        <div class=\"pager-item page-num-input\"><input type=\"text\" id=\"jump\" value=\"\"/></div>
        <div class=\"pager-item\">页</div>
        <a href=\"javascript:jump();\"><div class=\"pager-item goto\" style=\"margin-left: 2px;\">跳转</div></a>
        <div class=\"pager-item\">$current/$totalPage</div>
        <input type=\"hidden\" id=\"current\" value=\"$current\">
        <input type=\"hidden\" id=\"keyword\" value=\"$keyword\">";
            }

            echo "</div>";



        }


    }




}