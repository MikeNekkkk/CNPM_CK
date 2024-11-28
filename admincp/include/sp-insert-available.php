<?php
if (isset($_POST["act"])) {
  include "connect.php"; // Kết nối cơ sở dữ liệu

  $tensp = strtolower(trim($_POST["tensp"])); // Lấy tên sản phẩm từ form
  $soluong_nhap = intval($_POST["soluongbani"]); // Số lượng nhập
  $id = md5($kd); // Tạo id từ tensp

  // Truy vấn để lấy id dựa trên tensp
  $query_id = "SELECT id FROM sanpham WHERE tensp='$tensp'";
  $result_id = mysql_query($query_id);

  if (mysql_num_rows($result_id) != 0) {
    // Lấy id của sản phẩm
    $row = mysql_fetch_assoc($result_id);
    $id = $row['id']; // Gán id từ cơ sở dữ liệu
    
    // Truy vấn lấy số lượng hiện tại của sản phẩm
    $query_soluong = "SELECT soluongban FROM sanpham WHERE id='$id'";
    $result_soluong = mysql_query($query_soluong);
    
    if (mysql_num_rows($result_soluong) != 0) {
      $row = mysql_fetch_assoc($result_soluong);
      $current_soluong = intval($row['soluongban']); // Số lượng hiện tại
      $new_soluong = $current_soluong + $soluong_nhap; // Cộng thêm số lượng mới

      // Cập nhật số lượng vào cơ sở dữ liệu
      $sql = "UPDATE sanpham SET soluongban = '$new_soluong' WHERE id='$id'";
      $kq = mysql_query($sql);

    

      if (!$kq) {
        echo "<script>alert('Có lỗi SQL! Cập nhật lại!');</script>";
      } else {
        echo "<script>alert('Nhập kho thành công!');window.location='?m=sp&b=sp-list'</script>";
      }
    } else {
      echo "<script>alert('Không tìm thấy thông tin số lượng của sản phẩm này!');</script>";
    }
  } else {
    echo "<script>alert('Không tìm thấy sản phẩm này!');</script>";
    exit; // Ngừng xử lý nếu sản phẩm không tồn tại
  }
}
?>

 
<?php
	include("connect.php");
	function print_option($sql)
	{
		$kq=mysql_query($sql);
		while ($r=mysql_fetch_array($kq))
			echo "<option value=$r[0]> $r[1] </option>";
	}
?>
<table width="735" border="0" cellspacing="0" cellpadding="0" ">
  <tr>
    <td colspan="2" class="tieude" align="center" border-left:1px solid #CCCCCC">THÊM SẢN PHẨM ĐÃ TỒN TẠI</td>
  </tr>  
  <?php
  if(isset($_REQUEST["n"]))  
	  echo "<form method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return sp_insert_m(menu.value,tensp.value,hinh.value,ghichu.value);\" id=\"forminsert\" name=\"forminsert\">";
  else
	  echo "<form method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return sp_insert(loaisp.value,tensp.value,hinh.value,ghichu.value);\" id=\"forminsert\" name=\"forminsert\">";
  
  ?>

  <?php
$n = $_GET["n"];
if (isset($n)) {
    echo "";
} else {
    echo "<tr><td style=\"padding-left:80px\" height=\"30\"> Tên sản phẩm:</td>"; 
    echo "<td><select name=\"tensp\" style=\"width:240px;\" onChange=\"comboChange(this.value)\">
        <option value=\"choncm\">-- Chọn Tên sản phẩm --</option>";
        
    // Truy vấn sản phẩm và in tên sản phẩm vào các option
    $result = mysql_query("SELECT tensp FROM sanpham order by id_loai ASC");
    while ($row = mysql_fetch_assoc($result)) {
        // Hiển thị tên sản phẩm, nhưng lưu id sản phẩm làm giá trị của option
        echo "<option value=\"" . $row['tensp'] . "\">" . $row['tensp'] . "</option>";
    }

    echo "</select></td></tr>";
}
?>


  <tr>
  	<td colspan="2" style="padding-left: 50px">
    </td>
  </tr>

  <tr bgcolor="#FFFFFF">
    <td style="padding-left:80px" height="30">số lượng:</td>
    <td><input name="soluongbani" type="text" maxlength="20" style="width:240px" value="<?php echo "$soluong_nhap"; ?>" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')"></td>
  </tr>
 
  <tr>
  	<td align="center" colspan="2" height="35" style="border-bottom:1px solid #CCCCCC ">
    <input name="" type="submit" value="Thêm" class="button" onmouseover="style.background='url(../images/button-2-o.gif)'" onmouseout="style.background='url(../images/button-o.gif)'">
    <input name="" type="reset" value="Xóa trắng" class="button" onmouseover="style.background='url(../images/button-2-o.gif)'" onmouseout="style.background='url(../images/button-o.gif)'">    
    </td>
  </tr>
  <input type="hidden" name="act">
  </form>
</table>
