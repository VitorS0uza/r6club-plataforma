<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="30dc01bf-9e88-4bdc-9685-9e325a4fc37b";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
<?php
if(isset($_SESSION['login_id']) and !empty($_SESSION['login_id'])){
?>
<header>
		<div id="headerall">
				<div class="dropdown">
				<button class="dropbtn"><a href="#"></a>MENU</button>
				 <div class="dropdown-content">
    				<a href="/index"><?php echo $lang_pagina_inicial; ?></a>
    				<a href="/rank"><?php echo $lang_placar_de_lideres; ?></a>
    				<a href="/premium"><?php echo $lang_seja_premium; ?></a>
    				<?php
						if(isset($img_perfil) and $img_perfil === ""){
							$url_img = "/uploads/default/default-user.jpg";
						}else{
							$url_img = $img_perfil;
						}
					?>
    				<span><img alt="Imagem de perfil" style="width:32px; height:32px;" src="<?php echo $url_img; ?>"/><?php echo $nick;?></span>
					<a class="log1" href="/profile/<?php echo $_SESSION['login_id']; ?>"><?php echo $lang_perfil; ?><i class="fas fa-user"></i></a>
					<a class="log2" href="/logout"><?php echo $lang_sair; ?><i class="fas fa-sign-out-alt"></i></a>
  				</div>
				</div>
			
			<div id="logo">
			<button type="button" name="Jogar" id="jogaragora"><?php echo $lang_jogar_agora; ?></button>
			<a title="Rainbow 6: Club" href="index"><img style="width:90px; height:90px;" title="Rainbow 6: Club" alt="Logo Rainbow 6: Club" src="/img/logo.png" /></a>
			</div>
		</div>
	</header>
<?php
}else{
?>
<header>
		<div id="headerall">
			<nav>
				<div class="dropdown">
				<button class="dropbtn"><a href="#"></a>MENU</button>
				 <div class="dropdown-content">
    				<a href="/index"><?php echo $lang_pagina_inicial; ?></a>
    				<a href="/premium"><?php echo $lang_seja_premium; ?></a>
    				
  				</div>
				</div>
			</nav>

			<div id="logo">
			<button type="button" name="Jogar" id="jogaragora"><?php echo $lang_jogar_agora; ?></button>
			<a title="Rainbow 6: Club" href="index"><img style="width:90px; height:90px;" title="Rainbow 6: Club" alt="Logo Rainbow 6: Club" src="/img/logo.png" /></a>
			</div>
		</div>
	</header>
<?php	
}
?>