<?php

class lib_pagination
{
    
    public $totalRecords;           // @var type 总记录数
    public $perPageRows;            // @var type 每页显示记录数
    public $nowPage;                // @var type 当前页码
    public $totalPages;             // @var type 总页数
    public $reqParam;               // @var type 请求参数
    public $reqUrl;                 // @var type 当前请求的url地址

    private $adjacentsPage = 3;     // @var type 当前页面左边和右边相邻的显示的页码数量
    private $first_last    = 2;     // @var type 首尾显示的页码数量
    
    public function __construct($nowPage, $totalRecords, $perPageRows, $reqParam=[], $reqUrl='') 
    {
        if($perPageRows <= 0)
            $perPageRows = 10;

        $this->totalRecords  = $totalRecords;
        $this->perPageRows   = $perPageRows > 0 ? $perPageRows : 10;
        $this->totalPages         = ceil( $totalRecords/$perPageRows );
        
        if($nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        } elseif ($nowPage<=1) {
            $this->nowPage = 1;
        } else {
            $this->nowPage = $nowPage;
        }
        
        $this->reqParam = $reqParam;
        $this->reqUrl = empty($reqUrl)? $_SERVER['SCRIPT_NAME'] : $reqUrl;
    }
    
    /**
     * 分页
     */
    public function makePage()
    {
        $adjacentsPage = $this->adjacentsPage;
        $first_last    = $this->first_last;
        //分页html start
        $paginationHtml = '';
        if($this->totalPages >= 2)
        {
            $paginationHtml .= "<ul class='pagination'>";
            if($this->nowPage<=1) {
                $paginationHtml .= "<li class='prev disabled'><span>上一页</span></li>";
            } else {
                $this->reqParam['page'] = $this->nowPage-1;
                $paginationHtml .= "<li class='prev'><a href='{$this->reqUrl}?".http_build_query($this->reqParam)."'>上一页</a></li>";
            }

            $start = 1;
            $end = 10;
            if ($this->nowPage - $first_last - 1 <= $adjacentsPage) {
                $start = 1;
            } else {
                $start = $this->nowPage - $adjacentsPage ;
                for ($i=1; $i <= $first_last; $i++) { 
                    $this->reqParam['page'] = $i;
                    $paginationHtml .= "<li class='prev'><a href='{$this->reqUrl}?".http_build_query($this->reqParam)."'>$i</a></li>";
                }
                $paginationHtml .= "<li class='prev'><a style='background-color:#f5f5f5;'>. . .</a></li>";
            }

            if ($this->nowPage+$adjacentsPage+$first_last >= $this->totalPages) {
                $end = $this->totalPages;
            }else{
                $end = $this->nowPage + $adjacentsPage ;
            }

            for($i=$start;$i<=$end;$i++)
            {
                if($i==$this->nowPage) {
                    $paginationHtml .= "<li class='active'><span>$i</span></li>";
                } else {
                    $this->reqParam['page'] = $i;
                    $paginationHtml .= "<li><a href='{$this->reqUrl}?".http_build_query($this->reqParam)."'>$i</a></li>";
                }
                
            }

            if (($this->nowPage + $adjacentsPage + $first_last) < $this->totalPages) {
                $paginationHtml .= "<li class='prev'><a style='background-color:#f5f5f5;'>. . .</a></li>";
                for ($i = $this->totalPages - $first_last + 1; $i <= $this->totalPages; $i++) { 
                    $this->reqParam['page'] = $i;
                    $paginationHtml .= "<li class='prev'><a href='{$this->reqUrl}?".http_build_query($this->reqParam)."'>$i</a></li>";
                }
            }

            if($this->nowPage >= $this->totalPages) {
                $paginationHtml .= "<li class='next disabled'><span>下一页</span></li></ul>";
            } else {
                $this->reqParam['page'] = $this->nowPage+1;
                $paginationHtml .= "<li class='next'><a href='{$this->reqUrl}?".http_build_query($this->reqParam)."'>下一页</a></li></ul>";
            }
        }
        //分页html end
        return [
            'total'      => $this->totalRecords,
            'page'       => $this->totalPages,
            'now'        => $this->nowPage,
            'next'       => $this->nowPage + 1,
            'prex'       => $this->nowPage - 1,
            'pagination' => $paginationHtml,
        ];
    }
    
}