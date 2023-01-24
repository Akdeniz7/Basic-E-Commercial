<?php
if(isset($_SESSION["Yonetici"])){
?>
	<table width="1065" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr height="100%">
			<td width="300" align="center" bgcolor="#001d26" valign="top"><table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
				<tr height="70">
					<td align="center"><a href="index.php?SKD=0&SKI=0"><img src="../Resimler/Logo.png" border="0"></a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=106">&nbsp;SİPARİŞLER</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=116">&nbsp;HAVALE BİLDİRİMLERİ</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=94">&nbsp;ÜRÜNLER</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=82">&nbsp;ÜYELER</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=90">&nbsp;YORUMLAR</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=1">&nbsp;SİTE AYARLARI</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=57">&nbsp;MENÜLER</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=9">&nbsp;BANKA HESAP AYARLARI</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=5">&nbsp;SÖZLEŞMELER VE METİNLER</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=21">&nbsp;KARGO AYARLARI</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=33">&nbsp;BANNER AYARLARI</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=45">&nbsp;DESTEK İÇERİKLERİ</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=0&SKI=69">&nbsp;YÖNETİCİLER</a></td>
				</tr>
				<tr height="50">
					<td align="left" style="border-bottom: 1px dashed #00c8ff;" class="AnaMenuler"><a href="index.php?SKD=4">&nbsp;ÇIKIŞ</a></td>
				</tr>
			</table></td>
			<td width="5" align="center" bgcolor="#FF0000" valign="top">&nbsp;</td>
			<td width="760" align="center" valign="top"><?php
				if((!$IcSayfaKoduDegeri) or ($IcSayfaKoduDegeri=="") or ($IcSayfaKoduDegeri==0)){
					include($SayfaIc[0]);
				}else{
					include($SayfaIc[$IcSayfaKoduDegeri]);
				}					
			?></td>
		</tr>
	</table>
<?php
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>