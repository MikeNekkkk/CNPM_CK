<?php
	include("connect.php");
	function print_option($sql4)
	{
		$kq4=mysql_query($sql4);
		while ($r4=mysql_fetch_array($kq4))
			echo "<option value=$r4[0]> $r4[0] - $r4[1] </option>";
	}
?>
<form method="post" id="frm" name="form">
<table width="735" height="70" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" bordercolordark="#FFFFFF">
	  <tr>
      	<td style="border-top:1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left:1px solid #CCCCCC"><div align="left" style="color:#d4340c; font-family:Tahoma; font-size: 16px; font-weight:bold; padding-left:20px">QUẢN LÝ SẢN PHẨM 	 
      	</div></td>
      	<td style="border-top:1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; height:65px; width:55px">
		<input type="button" value='' onClick="document.form.action='../admincp/?m=sp&b=sp-insert'; document.form.submit();" style="background:url(../images/bt_them.jpg); width:55px; height:65px;">
		</td>		
		<td style="border-top:1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-right:1px solid #CCCCCC; height:65px; width:55px">
		<input type="button" value='' onClick="document.form.action='../admincp/?m=sp&b=sp-xl-del';document.form.submit();" style="background:url(../images/bt_xoa.jpg); width:55px; height:65px;">       
        </td>
      </tr>
    </table>
    
<table width="735" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="9" class="tieude" align="center">DANH SÁCH SẢN PHẨM</td>
  </tr>
  <tr height="30" bgcolor="#ffcc99">
    <td align="center" width="50" style="border-left:1px solid #333;border-right:1px solid #333"><strong>Chọn</strong></td>
    <td align="center" width="80" style="border-right:1px solid #333"><strong>Tên sản phẩm</strong></td>
    <td align="center" width="135" style="border-right:1px solid #333"><strong>Loại sản phẩm</strong></td>
    <td align="center" width="100" style="border-right:1px solid #333"><strong>Mô tả</strong></td>
    <td align="center" width="100" style="border-right:1px solid #333"><strong>Hình</strong></td>
    <td align="center" width="100" style="border-right:1px solid #333"><strong>Giá ( VND )</strong></td>
    <td align="center" width="80" style="border-right:1px solid #333"><strong>Số lượng</strong></td>
    <td align="center" width="50" style="border-right:1px solid #333"><strong>Sửa</strong></td>
    <td align="center" width="50"><strong>Xóa</strong></td>    
  </tr>  
<?php
		$idl=$_GET["idl"];
		if(isset($_REQUEST["idl"])){
	        $kq=mysql_query("select count(*) from sanpham,loaisanpham where sanpham.id_loai=loaisanpham.id_loai and sanpham.id_loai=$idl"); }
		else{
	        $kq=mysql_query("select count(*) from sanpham"); }
        $r=mysql_fetch_array($kq);
        $numrow=$r[0];		
        //số record cho 1 trang
        $pagesize=20;
        //Tính tổng số trang
        $pagecount=ceil($numrow/$pagesize);			
        //Xác định số trang cho mỗi lần hiển thị
        $segsize=5;
        //Thiết lập trang hiện hành
        if(!isset($_GET["page"]))
			 $curpage=1;
        else	
        	 $curpage=$_GET["page"];
        if($curpage<1)
			 $curpage=1;
        if($curpage>$pagecount) $curpage=$pagecount;
        //Xác định số phân đoạn của trang
        $numseg=($pagecount % $segsize==0)?($pagecount/$segsize):(int)($pagecount/$segsize+1);
        //Xác định phân đoạn hiện hành của trang
        $curseg=($curpage % $segsize==0)?($curpage/$segsize):(int)($curpage/$segsize+1);   
		$k=($curpage-1)*$pagesize;
		
	//******************************** Nội Dung *********************************//
		if(isset($_REQUEST["idl"])){
			$sql3="select sanpham.*,loaisanpham.id_loai,loaisanpham.tenloaisp from sanpham,loaisanpham where sanpham.id_loai=loaisanpham.id_loai and sanpham.id_loai=$idl order by tensp limit $k,$pagesize";}
		else{
			$sql3="select * from sanpham order by tensp limit $k,$pagesize";}
		$kq3=mysql_query($sql3);
		if(!$kq3)
			echo "";
		else{
		while($r3=mysql_fetch_array($kq3))
		{
			$tensp=$r3['tensp']; $mota=$r3['mota'] ; $soluongban=$r3["soluongban"];
			$mota=$r3["mota"];
			$hinh=$r3['hinh'] ; $gia=number_format($r3['gia'],0,'','.') ;$id=$r3["id"];
			$sql2="select * from loaisanpham,sanpham where loaisanpham.id_loai=sanpham.id_loai and sanpham.id='$id'";
			$kq2=mysql_query($sql2);
			while($r2=mysql_fetch_array($kq2))
			{
				$tenloaisp=$r2["tenloaisp"];
  ?>
  <tr>
  <td width="50" align="center" style="border-left:1px solid #333;border-bottom:1px solid #333; border-right:1px solid #333">
  <input type="checkbox" name="chon[]" value="<?php echo $id; ?>"/></td>  
    <td width="80" align="center" style="border-bottom:1px solid #333; border-right:1px solid #333"><b><?php echo "$tensp"; ?></b></td>
    <td width="135" align="center" style="border-bottom:1px solid #333; border-right:1px solid #333"><?php echo "$tenloaisp"; ?></td>
    <td width="100" style="border-bottom:1px solid #333; border-right:1px solid #333">
	<div align="center" style="padding-left:3px; padding-right:3px;" onclick="var win=window.open('mota.php?id=<?php echo $id; ?>', 'open_window', 'width=570, height=320, left=0, top=0')">Xem mô tả</div></td>
    <td width="100" align="center" style="border-bottom:1px solid #333; border-right:1px solid #333"><div onclick="var win=window.open('../zoom.php?id=<?php echo $id; ?>', 'open_window', 'width=405, height=530, left=0, top=0')"><img src="../sanpham/small/<?php echo "$hinh"; ?>" width="90" height="90"></div></td>
	<td width="100" align="center" style="border-bottom:1px solid #333; border-right:1px solid #333"><?php echo "$gia"; ?></td>
	<td width="80" align="center" style="border-bottom:1px solid #333; border-right:1px solid #333"><?php echo "$soluongban"; ?></td>    
    <td width="50" align="center" style="border-bottom:1px solid #333; border-right:1px solid #333"><a href="?m=sp&b=sp-update&id=<?php echo $id; ?>">Sửa</a></td>
    <td width="50" align="center" style="border-bottom:1px solid #333; border-right:1px solid #333"><a href="?m=sp&b=sp-del&id=<?php echo $id; ?>" onclick="return check()">Xóa</a>
    </td>
  </tr>
 <?php
	  		}
		}
		}
 ?>
  <tr>
	<td colspan="9" class="ketthuc" bgcolor="#ffcc99">
 <?php
    if($numrow==0)
		echo "Không tìm thấy sản phẩm nào!!";
	else{ 
	if(isset($_REQUEST["idl"])){
		if($curseg>1)
			echo "<a href='?m=sp&b=sp-list&idl=$idl&page=".(($curseg-1)*$segsize)."'><b>Previous</b></a> &nbsp;";
			$n=$curseg*$segsize<=$pagecount?$curseg*$segsize:$pagecount;
			for($i=($curseg-1)*$segsize+1;$i<=$n;$i++)
			{
				if($curpage==$i)
					echo "<a href='?m=sp&b=sp-list&idl=$idl&page=".$i."'><font color='#FF0000'>[".$i."]</font></a> &nbsp;";
				else
					echo "<a href='?m=sp&b=sp-list&idl=$idl&page=".$i."'><font color='#000'>[".$i."]</font></a> &nbsp;";
			}
			if($curseg<$numseg)
			echo "<a href='?m=sp&b=sp-list&idl=$idl&page=".(($curseg*$segsize)+1)."'><b>Next</b></a> &nbsp;";				
	}
	else{
		if($curseg>1)
			echo "<a href='?m=sp&b=sp-list&page=".(($curseg-1)*$segsize)."'><b>Previous</b></a> &nbsp;";
			$n=$curseg*$segsize<=$pagecount?$curseg*$segsize:$pagecount;
			for($i=($curseg-1)*$segsize+1;$i<=$n;$i++)
			{
				if($curpage==$i)
					echo "<a href='?m=sp&b=sp-list&page=".$i."'><font color='#FF0000'>[".$i."]</font></a> &nbsp;";
				else
					echo "<a href='?m=sp&b=sp-list&page=".$i."'><font color='#FFF'>[".$i."]</font></a> &nbsp;";
			}
			if($curseg<$numseg)
			echo "<a href='?m=sp&b=sp-list&page=".(($curseg*$segsize)+1)."'><b>Next</b></a> &nbsp;";				
	}
	}
?>
    </td>
  </tr> 
</table>
</form>