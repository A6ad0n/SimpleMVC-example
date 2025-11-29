$(function(){
    
    console.log('Привет, это страый js ))');
    init_get();
    init_post();
});

function init_get() 
{
    $('.ajaxArticleBodyByGet').one('click', function(){
        var contentId = $(this).attr('data-contentId');
        console.log('ID статьи = ', contentId); 
        contentUrl = 'index.php?route=' + 'ajax/showContentsHandler&articleId=' + contentId
        showLoaderIdentity();
        $.ajax({
            url: contentUrl
        })
        .done (function(obj){
            hideLoaderIdentity();
            console.log('Ответ получен');
            console.log(obj);
            $('#summary' + contentId).replaceWith(obj);
        })
        .fail(function(xhr, status, error){
            hideLoaderIdentity();
    
            console.log('ajaxError xhr:', xhr); // выводим значения переменных
            console.log('ajaxError status:', status);
            console.log('ajaxError error:', error);
    
            console.log('Ошибка соединения при получении данных (GET)');
        });
        
        return false;
        
    });  
}

function init_post() 
{
    $('.ajaxArticleBodyByPost').one('click', function(){
        var content = $(this).attr('data-contentId');
        contentUrl = 'index.php?route=' + 'ajax/showContentsHandler'
        showLoaderIdentity();
        $.ajax({
            url: contentUrl,
            dataType: 'json',
            data: {articleId: content},
            method: 'POST'
        })
        .done (function(obj){
            hideLoaderIdentity();
            console.log('Ответ получен', obj.content);
            $('#summary' + content).replaceWith(obj.content);
        })
        .fail(function(xhr, status, error){
            hideLoaderIdentity();
    
    
            console.log('Ошибка соединения с сервером (POST)');
            console.log('ajaxError xhr:', xhr); // выводим значения переменных
            console.log('ajaxError status:', status);
            console.log('ajaxError error:', error);
        });
        
        return false;
        
    });  
}
