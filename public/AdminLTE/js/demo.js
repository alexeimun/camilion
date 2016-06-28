$(function () {

    var status = null;
    //Persistent Menu
    $('li.treeview').click(function () {
        //if (localStorage.boxed) localStorage.boxed *= -1;
        //else localStorage.boxed = 1;
        //console.log($(this));
    });

    $('ul.sidebar-menu > li.treeview > ul.treeview-menu > li.treeview').click(function () {
        //if (localStorage.boxed) localStorage.boxed *= -1;
        //else localStorage.boxed = 1;
        //console.log('segundo nivel');
    });
});
