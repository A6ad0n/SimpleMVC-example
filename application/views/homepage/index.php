<ul class="list-none pl-0 w-3/4">
<?php 
foreach ($preparedData as $row) { 
  $hyperNames = array();
  foreach($row['noteAuthors'] as $author) {
      $hyperNames[] = "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/adminusers/index&id=' 
      . $author->id . ">{$author->login}</a>"); 
  }
?>
  <li id='<?php echo $row['noteId']?>' class="mb-8">
      <h2 class="text-[#edc951] leading-normal mt-[.4em] mb-[.4em]">
          <span class="inline-block w-[100px] h-[24px] text-[.75em] font-bold align-middle text-[#eb6841] uppercase">
              <?php 
              $date = DateTime::createFromFormat('Y-m-d', $row['notePublicationDate']);
              echo $date->format('j F');
              ?>
          </span>
          
          <div class="inline-block h-[28px]">
          <?= '<a class="font-bold text-[1.5em]" href=' . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/notes/index&id=' 
		      . $row['noteId'] . ">{$row['noteTitle']}</a>" ) ?>
          </div>
          
          <?php if (isset($row['categoryId'])) { ?>
              <span class="italic font-normal text-[90%] text-gray-500/80 block leading-loose">
                  in 
                  <?php 
                    echo "<a class='underline' href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/categories/index&id=' 
                    . $row['categoryId'] . ">{$row['categoryName']}</a>");                    
                  ?>
              </span>
          <?php }
          else { ?>
              <span class="italic font-normal text-[60%] text-gray-500 block leading-8">
                  <?php echo "Без категории"?>
              </span>
          <?php } ?>
      </h2>
      <?php if (isset($row['subcategoryId']) && $row['subcategoryId']) { ?>
              <span class="underline text-blue-800 visited:text-purple-800">
                  <?php
                    echo "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/subcategories/index&id=' 
                    . $row['subcategoryId'] . ">Subcategory: {$row['subcategoryName']}</a>");
                  ?>
              </span>
          <?php } ?>
      <?php if (!empty($row['noteAuthors'])) { ?>
          <div class="italic"> Authors: <?php echo implode(', ', $hyperNames)?></div>
      <?php } ?>
      <?php
          $content = mb_substr($row['noteContent'], 0, 50);
          $lastSpace = mb_strrpos($content, ' ');
          if ($lastSpace !== false) {
              $content = mb_substr($content, 0, $lastSpace);
          }
          ?>
      <p id="summary<?php echo $row['noteId']?>" class="mt-[16px] mb-[16px] pl-[100px]"><?php echo htmlspecialchars($content . '...') ?></p>
      <img id="loader-identity" class="hidden float-right" src="JS/ajax-loader.gif" alt="gif">
      
      <ul class="ml-0 pl-[10px]">
          <li class="inline mr-[5px] border border-black p-[3px] text-[12px]"><a class="ajaxArticleBodyByPost cursor-pointer underline text-blue-800 visited:text-purple-800" data-contentId="<?php echo $row['noteId']?>">Показать продолжение (POST)</a></li>
          <li class="inline mr-[5px] border border-black p-[3px] text-[12px]"><a class="ajaxArticleBodyByGet cursor-pointer underline text-blue-800 visited:text-purple-800" data-contentId="<?php echo $row['noteId']?>">Показать продолжение (GET)</a></li>
          <li class="inline mr-[5px] border border-black p-[3px] text-[12px]"><a class="ajaxArticlePost cursor-pointer underline text-blue-800 visited:text-purple-800" data-contentId="<?php echo $row['noteId']?>">(POST) -- NEW</a></li>
          <li class="inline mr-[5px] border border-black p-[3px] text-[12px]"><a class="ajaxArticleGet cursor-pointer underline text-blue-800 visited:text-purple-800" data-contentId="<?php echo $row['noteId']?>">(GET)  -- NEW</a></li>
      </ul>
      <div class="float-right text-[14px] underline text-blue-800 visited:text-purple-800">
      <?= "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/notes/index&id=' 
		      . $row['noteId'] . ">Показать полностью</a>" ) ?>
      </div>
  </li>
<?php } ?>
</ul>
<p><a class="underline text-blue-800 visited:text-purple-800" href="./?action=archive">Article Archive</a></p>