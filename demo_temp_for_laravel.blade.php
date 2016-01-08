<html>
<head>
    <title>FilterManger</title>
    <meta name="description" content="FilterManager - 产品列表筛选管理器，让你优雅的获得筛选器链接(Filter manager package for product list,elegant generate url.)">
    <style>
     body{margin: 0;background-color: #f9f9f9}
     .filter_wrap{
        width: 90%;margin: auto;margin-top: 50px;
        background: #fff;color: #333;font-size: 14px;font-family: "Helvetica Neue", "Microsoft YaHei", "微软雅黑", "Hiragino Sans GB", sans-serif;
        border: 1px solid #ddd;padding: 5px 30px;
     }
     .filter_wrap fieldset{border: 0 none;padding: 7px 0;}
     .filter_wrap .fieldset{border-top: 1px dotted #ddd;}
     .filter_wrap .filter_header{font-size: 14px;color: #000;font-weight: bold;}
     .filter_wrap .filter_ul li.item_hide{display: none;}
     .filter_wrap .filter_ul li.item_more{color:#e67e22;cursor: pointer;}
     .filter_wrap .filter_ul{float: left;padding: 0;margin-bottom: 0;max-width: 965px;margin-top: 0;}
     .filter_wrap .filter_ul li.name{color: #e67e22;}
     .filter_wrap .filter_ul li{display: inline-block;margin-right: 18px;margin-bottom: 4px;margin-top: 4px;}
     .filter_wrap .filter_ul li.active a{background: #f90;color: #fff;padding: 1px 3px;border-radius: 3px !important;}
     .filter_wrap .filter_ul li a{text-decoration: none;color: #444;}
     .filter_wrap input{position:relative;top :2px;}
     .filter_wrap .filter_header .filter_ul li.selected{
            font-weight: normal;border: 1px solid #f90;color: #f90;border-radius: 3px;
            padding: 2px 5px;margin-left: 3px;margin-right: 3px;}
     .filter_wrap .filter_header .filter_ul li.selected:hover{background: #f90;color: #fff;}
     .filter_wrap .filter_header .filter_ul li.selected a{color: #f90}
     .filter_wrap .filter_header .filter_ul li.selected:hover a{color: #fff;}
    </style>
</head>
<body>
    <div class="container">
        <div class="filter_wrap">
        <fieldset class="filter_header">
        <ul class="filter_ul">
        <li>所有分类 ></li>
        @if(FilterManager::has('gender') !== false)
            <li class="selected">性别：{{FilterManager::has('gender')}}&nbsp;
            <a href="{{FilterManager::url('gender', FM_SELECT_ALL)}}" type="button" class="close">×</a>
            </li>
        @endif
        @if(FilterManager::has('types') !== false)
            <li class="selected">方式：{{FilterManager::has('types')}}&nbsp;
            <a href="{{FilterManager::url('types', FM_SELECT_ALL)}}" type="button" class="close">×</a>
            </li>
        @endif
        @if(FilterManager::has('city') !== false)
            <li class="selected">城市：{{FilterManager::has('city')}}&nbsp;
            <a href="{{FilterManager::url('city', FM_SELECT_ALL, true, ['counties', 'towns'])}}" type="button" class="close">×</a>
            </li>
        @endif
        </ul>
        </fieldset>
        <fieldset class="fieldset">
            <ul class="filter_ul">
            <li>教师性别：</li>
                <li class="item all {{FilterManager::isActive('gender', FM_SELECT_ALL, 'active', '')}}">
                    <a href="{{FilterManager::url('gender', FM_SELECT_ALL)}}">全部</a>
                </li>
                <li class="item @if(FilterManager::isActive('gender','male')) active @endif">
                    <a href="{{FilterManager::url('gender','male')}}">男</a>
                </li>
                <li class="item @if(FilterManager::isActive('gender','female')) active @endif">
                    <a href="{{FilterManager::url('gender','female')}}">女</a>
                </li>
            </ul>
        </fieldset>
        <fieldset class="fieldset">
           <ul class="filter_ul">
               <li>上课方式：</li>
               <li class="item all @if(FilterManager::isActive('types', FM_SELECT_ALL)) active @endif">
                    <a href="{{FilterManager::url('types', FM_SELECT_ALL)}}">全部</a></li>
               <li class="item @if(FilterManager::isActive('types','location_teacher')) active @endif">
                    <a href="{{FilterManager::url('types','location_teacher',true)}}">
                    <input type="checkbox" @if(FilterManager::isActive('types','location_teacher')) checked @endif />
                    &nbsp;在教师家</a>
               </li>

               <li class="item @if(FilterManager::isActive('types','location_student')) active @endif">
                    <a href="{{FilterManager::url('types','location_student',true)}}">
                    <input type="checkbox" @if(FilterManager::isActive('types','location_student')) checked @endif />
                    &nbsp;在学生家</a>
               </li>

               <li class="item @if(FilterManager::isActive('types','location_studio')) active @endif">
                   <a href="{{FilterManager::url('types','location_studio',true)}}">
                   <input type="checkbox" @if(FilterManager::isActive('types','location_studio')) checked @endif />
                   &nbsp;在教师工作室</a>
               </li>

               <li class="item @if(FilterManager::isActive('types','location_online')) active @endif">
                   <a href="{{FilterManager::url('types','location_online',true)}}">
                   <input type="checkbox" @if(FilterManager::isActive('types','location_online')) checked @endif />
                   &nbsp;在线陪练</a>
               </li>
           </ul>
       </fieldset>
        <fieldset class="fieldset">
          <ul class="filter_ul">
              <li>上课时间：</li>
              <li class="item all @if(FilterManager::isActive('weekdays', FM_SELECT_ALL)) active @endif">
              <a href="{{FilterManager::url('weekdays', FM_SELECT_ALL)}}">全部</a>
              </li>
              <li class="item @if(FilterManager::isActive('weekdays','1')) active @endif">
              <a href="{{FilterManager::url('weekdays','1',true)}}">
              <input type="checkbox" {{FilterManager::isActive('weekdays','1','checked','')}} />&nbsp;周一</a>
              </li>
              <li class="item @if(FilterManager::isActive('weekdays','2')) active @endif">
              <a href="{{FilterManager::url('weekdays','2',true)}}">
              <input type="checkbox" @if(FilterManager::isActive('weekdays','2')) checked @endif />&nbsp;周二</a>
              </li>
              <li class="item @if(FilterManager::isActive('weekdays','3')) active @endif">
              <a href="{{FilterManager::url('weekdays','3',true)}}">
              <input type="checkbox" @if(FilterManager::isActive('weekdays','3')) checked @endif />&nbsp;周三</a>
              </li>
              <li class="item @if(FilterManager::isActive('weekdays','4')) active @endif">
              <a href="{{FilterManager::url('weekdays','4',true)}}">
              <input type="checkbox" @if(FilterManager::isActive('weekdays','4')) checked @endif />&nbsp;周四</a>
              </li>
              <li class="item @if(FilterManager::isActive('weekdays','5')) active @endif">
              <a href="{{FilterManager::url('weekdays','5',true)}}">
              <input type="checkbox" @if(FilterManager::isActive('weekdays','5')) checked @endif />&nbsp;周五</a>
              </li>
              <li class="item @if(FilterManager::isActive('weekdays','6')) active @endif">
              <a href="{{FilterManager::url('weekdays','6',true)}}">
              <input type="checkbox" @if(FilterManager::isActive('weekdays','6')) checked @endif />&nbsp;周六</a>
              </li>
              <li class="item @if(FilterManager::isActive('weekdays','7')) active @endif">
              <a href="{{FilterManager::url('weekdays','7',true)}}">
              <input type="checkbox" @if(FilterManager::isActive('weekdays','7')) checked @endif />&nbsp;周日</a>
              </li>
          </ul>
      </fieldset>
        <fieldset class="fieldset">
          <ul class="filter_ul">
              <li>其他条件：</li>
              <li class="item all @if(FilterManager::isActive('others', FM_SELECT_ALL)) active @endif "><a href="{{FilterManager::url('others')}}">全部</a></li>
              <li class="item @if(FilterManager::isActive('others','verify')) active @endif">
              <a href="{{FilterManager::url('others','verify',true)}}"><input type="checkbox" @if(FilterManager::isActive('others','verify')) checked @endif />&nbsp;认证教师</a>
              </li>
              <li class="item @if(FilterManager::isActive('others','have_multi_course')) active @endif">
              <a href="{{FilterManager::url('others','have_multi_course',true)}}"><input type="checkbox" @if(FilterManager::isActive('others','have_multi_course')) checked @endif  />
              &nbsp;有多人课程</a>
              </li>
          </ul>
        </fieldset>
    </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
$('.filter_wrap li.item a input:checkbox').click(function(){
            location.href = $(this).parent('a').attr('href');
        });
</script>
</html>
