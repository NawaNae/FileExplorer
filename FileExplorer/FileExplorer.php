<?php
//copy(src , dst)
//move,cut=rename("from","to");
//create=fopen("filename","w");fclose;
//rename

function create($fileName)
{
	$file=fopen($fileName,"w");
	fclose($file);
}
function move($from,$to)
{
	if(is_dir($from)&&is_dir($to))
	{rename($from,$to."/".basename($from));}
	else if(is_file($from)&&is_file($to))
	{rename($from,$to);}
	else if(is_file($from)&&is_dir($to))
	{rename($from,$to."/".basename($from));}
}

function delete($path)
{
    if (is_dir($path) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file)
        {
            if (in_array($file->getBasename(), array('.', '..')) !== true)
            {
                if ($file->isDir() === true)
                {
                    rmdir($file->getPathName());
                }
                else if (($file->isFile() === true) || ($file->isLink() === true))
                {
                    unlink($file->getPathname());
                }
            }
        }
        return rmdir($path);
    }
    else if ((is_file($path) === true) || (is_link($path) === true))
    {
        return unlink($path);
    }
    return false;
}

function main()
{
	if(isset($_POST['method']))
	{
		switch($_POST['method'])
		{
			case "copy":
				copy($_POST['src'],$_POST['dst']);
				break;
			case "rename":
				rename($_POST['src'],$_POST['dst']);
			break;
			case "remove":
				delete($_POST['src']);
				break;
			case "move":
				move($_POST['src'],$_POST['dst']);
				break;
			case "create":
				create($_POST['src']);
				break;
			case "createDir":
				mkdir($_POST['src']);
				break;
		}
	}
}
	main();
if(!isset($_POST['path'])){
echo'<head>
	<style>
        .icon>img
		{
			height:64px;
			width:64px;
        }
	</style>
	<script>
function POSTRequest(Url, paraments, httpcallback, errDisplayObj)
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4)
            if (xmlhttp.status == 200)
                httpcallback(xmlhttp);
            else
                if (typeof errDisplayObj != "undefined")
                    errDisplayObj.innerText ="Error\nFailed to load " + Url;
                else
                    alert("Error\nFailed to load " + Url);
    }
    xmlhttp.open("POST", Url, true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(paraments);
}
		function POSTRequestToObjHtml(Url, paraments, Obj) {
			POSTRequest(Url, paraments, function (xmlhttp) { Obj.innerHTML = xmlhttp.response;});
}
	</script>
</head>
<body>
    <form method="post">
        <select name="method">
            <option value="copy">複製</option>
            <option value="rename">重新命名</option>
            <option value="remove">刪除</option>
            <option value="create">新增檔案</option>
            <option value="createDir">新增資料夾</option>
            <option value="move">移動</option>
        </select>
        <input name="src" type="text" />
        <input name="dst" type="text" />
		<!--input disabled name="path" type="text" /-->
        <input type="submit" value="submit" />
    </form>
	<div class="menu">
		<div class="content">';
}
  function updir($path)
  {
	  $path=explode('/',$path);
	  $npath=$path[0];
	  for($i=1;$i<count($path)-1;$i++) {
		  $npath.='/' .$path[$i];
	  }
	  return $npath;
  }
  $FolderIco='http://icones.gratuites.web.free.fr/data/Folder%20Concept%20Icons/Folder%20Concept%20Icons%2007.ico' ;
  $FileIco='http://www.cc.ntut.edu.tw/~t105590029/Images/file_empty.png' ;
  $UpIco='https://upload.wikimedia.org/wikipedia/commons/thumb/2/20/Circle-icons-arrow-up.svg/2000px-Circle-icons-arrow-up.svg.png' ;
  if(!isset($_POST['path']) )
	$path='.' ;
  else
	$path=$_POST['path'];
  if ($handle=opendir($path)) {  //開啟現在的資料夾
	  echo '<div class="pathtext">' .$path.'</div>';
	  if($path!=='pages')
	  {
		  echo "<div class='icon' onclick=' POSTRequest(\"FileExplorer.php\", \"path=".updir($path)."\", function(txt){document.querySelector(\".menu>.content\").innerHTML=txt.response;});'>
        ";
		  echo "<img src='$UpIco' />";
		  echo "<div class='text'>上層文件</div><br>";
		  echo "
    </div>\n";
	  }
	  while (false !== ($file = readdir($handle))) {//避免搜尋到的資料夾名稱是false,像是0
		  if ($file != "." && $file != "..")
		  {//去除掉..跟.
			  if(is_dir($path.'/'.$file))
			  {
				  echo "<div class='icon' onclick=' POSTRequestToObjHtml(\"FileExplorer.php\", \"path=$path/$file\", document.querySelector(\".menu>.content\"));'>
        ";
				  echo "<img src='$FolderIco' />";
				  echo "<div class='text'>$file</div><br>";
				  echo "
    </div>\n";
			  }
			  else
			  {
				  echo "<div class='icon file' data-hash='main=$path/$file'>
        ";
				  echo "<img src='$FileIco' />";
				  echo "<div class='text'>$file</div><br>";
				  echo "
    </div>\n";
			  }
		  }
	  }
	  closedir($handle);
  }
  if(!isset($_POST['path']))
	  echo "
			</div>
		</div>
</body> ";
?>