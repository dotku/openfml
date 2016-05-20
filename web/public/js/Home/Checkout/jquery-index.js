$(".item-remove").click(function(){
    if (confirm("删除购物车物品")) {
        $(this).parents(".item-block").remove();
    }
})