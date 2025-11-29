<?php 
use ItForFree\SimpleMVC\Config;


$User = Config::getObject('core.user.class');

?>
<!DOCTYPE html>
<html>
    <?php include('includes/home/head.php'); ?>
    <body class="m-0 text-[#333] bg-[#00a0b0] font-['Trebuchet_MS',Arial,Helvetica,sans-serif] leading-[1.5em] whitespace-nowrap">
        <div class="w-[1000px] bg-white mx-auto my-5 p-5 rounded">
            <a href="/" class="block pr-[660px] pb-[20px] border-0 border-b border-[#00a0b0] mb-[35px]">
                <img class="w-[300px]"
             src="/logo.jpg" alt="WidgetNews" /></a>
            <?= $CONTENT_DATA ?>
            <?php include('includes/home/footer.php'); ?>
        </div>
    </body>
</html>

