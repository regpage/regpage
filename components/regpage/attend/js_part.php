<script>
// Modules
$(".members-lists-combo").change(function(){
    listsType = $(".members-lists-combo").val();
    switch (listsType) {
        case 'members': window.location = '/members'; break;
        case 'youth': window.location = '/youth'; break;
        case 'list': window.location = '/list'; break;
        case 'activity': window.location = '/activity'; break;
        case 'attend': window.location = '/attend'; break;
    }
});
</script>
<script src="/js/regpage/attend/script.js?v1"></script>
