这是一个培训机构的学生管理系统

1. 用的leveral5框架

2. 服务器:www.wdxychen.com 60.205.186.237

3.  登录账号: 白晓转 123456


数据库部分:

1. qin => type: 1 - 请假,  2 - 旷课,  3 - 迟到,  4 - 早退 , 5 -留级
       => time: 1 - 上午,  2 - 下午,  3 - 晚上,  4 - 全天


技术部分:

1. array_column()  返回输入数组(多维数组)中某个单一列的值。

2. 将两个数组重新组合的函数(百度):
	对键值的处理方式不同
	array_merge()   - 合并数组,覆盖两数组的键,时其组合
	array_merge_recursive()  - 递归追加数组, 相同键在一起重新组合成数组
	array_combine()   -  连接两个数组, 一个做键,一个做值

3. lavarel 时间选择器插件 moment ;
	http://blog.csdn.net/yushengphper/article/details/78498368

4. js 虽然不能用{{$a}} ,但能用 <?php echo ""?>

5. 猜测:饼图点击消失跟 onclick的冒泡执行有关,执行先后顺序不同;先执行tu()(最里面),后执行了排序(最外面);
	改为 $("body").click(function(){tu();})  解决!

6. js验证form表单: onsubmit="return validate_form(this)"

7. js 验证世家时间是否合法:(new Date(date1[0]).getDate()==date1[0].substring(date1[0].length-2)
	


小bug:

1.时间长了,登陆会取消,直接报错, 应做个判断,if($class){}else{"请重新登陆"}

2.老师权限怎么加


需要练习:

1. 用lavarel 和 js 写验证

2. js split() 方法用于把一个字符串分割成字符串数组。
