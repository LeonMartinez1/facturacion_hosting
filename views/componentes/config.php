<?php 

$empresa = fiscalName();
if($empresa){
    $page="view";
}else{
    $page="insert";
}


?>

<li class="nav-item px-3 d-flex align-items-center">
    <a href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/facturacion/views/config/$page"; ?>" class="nav-link text-body p-0">
        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer" aria-hidden="true"></i>
    </a>
</li>