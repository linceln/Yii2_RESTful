<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?php echo $user->id ?>
            <?php echo $user->username ?>
            <?php echo $user->mobile ?>
            <?php echo $user->created_at?>
        </li>
    <?php endforeach ?>
</ul>

<h1>JQuery ajax</h1>
<label>请输入搜索内容：</label>
<input id="keyword"/>
<button id="search">搜索</button><br>
<label id="searchResult"></label>

<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            $.ajax({
                type:"GET",
                url:"",
                dataType:'json',
                data:{

                },
                success:function (data) {

                },
                error:function (jqXHR) {
                    alert("请求失败：" + jqXHR.status + " " + jqXHR.statusText);
                }
            })
        })
    })
</script>
