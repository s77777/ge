(function (){
    d.addEventListener('DOMContentLoaded',function(){
        (async() => {
            let response = await fetch('/en/Index/getDataFromFile/'+fileName);
            let data = await response.json();
            let attrTable={table:{class:'table'},thead:{class:'thead-light'}};
            let table=new Table(data,attrTable);
            new AddToElementById(table,'table');
            let g=new Graphics(data);
            let btn=d.getElementById('button');
            btn.addEventListener('click',g.saveConfig.bind(null,g.getConfig('Morris')),false);
        })();
    });
})();

