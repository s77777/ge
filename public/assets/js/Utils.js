'use strict';
var d = document;

/*
 * @description creating a chart with data
 * @param object data {Colums: array, Rows: object {string: array}}
 */
class Graphics {

    constructor(data) {
        this.months=data.Columns;
        this.keys=Object.keys(data.Rows);
        this.dataChart=this.getDataChart(data);
        switch(chart) {
            case 'MorrisChartJS':
                this.cMorrisChart();
                break;
            case 'AmChartJS':
                this.cAmChart(this.keys,this.dataChart,this.getColor());
                break;
            default:
                break;
        }
    }

    cMorrisChart() {
        new Morris.Bar(this.getConfig('Morris'));
    }

    cAmChart(keys,data,color) {
        am4core.ready(function() {
        //am4core.useTheme(am4themes_animated);
        var chart = am4core.create("chart", am4charts.XYChart);
        chart.data = data;
        chart.parseDates=true;
        chart.dateFormatter.dateFormat = "yyyy-MM-dd";
        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "m";
        categoryAxis.numberFormatter.numberFormat = "#";
        categoryAxis.renderer.inversed = true;
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.cellStartLocation = 0.1;
        categoryAxis.renderer.cellEndLocation = 1;
        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            console.log("valueAxis",valueAxis);
        valueAxis.renderer.opposite = true;
        function createSeries(field,name,color) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueX = field;
            //series.dataFields.dateY = "m";
            series.dataFields.categoryY = "m";
            series.name = name;
            console.log("qwqeqwe",series.dataFields);
            series.columns.template.tooltipText = "{name}: [bold]{valueX}[/]";
            series.columns.template.height = am4core.percent(100);
            series.columns.template.fill = am4core.color(color);
            series.sequencedInterpolation = true;
            series.stroke = am4core.color(color);
            series.strokeWidth = 3;

            var valueLabel = series.bullets.push(new am4charts.LabelBullet());
            valueLabel.label.text = "{valueX}";
            valueLabel.label.horizontalCenter = "left";
            valueLabel.label.dx = 10;
            valueLabel.label.hideOversized = false;
            valueLabel.label.truncate = false;

            var categoryLabel = series.bullets.push(new am4charts.LabelBullet());
            categoryLabel.label.text = "{name}";
            categoryLabel.label.horizontalCenter = "right";
            categoryLabel.label.dx = -10;
            categoryLabel.label.fill = am4core.color("#343a40");
            categoryLabel.label.hideOversized = false;
            categoryLabel.label.truncate = false;
        }
        for(let i=0;i<keys.length;i++) {
            createSeries(keys[i], keys[i],color[i+1]);
        }
        chart.events.on("ready", function () {
            dateAxis.zoom({start:0.79, end:1});
        });
      });
    }
    /*
     * @description creating a data for chart
     * @param object data {Colums: array, Rows: object {string: array}}
     */
    getDataChart(data) {
        let res=[];
        let Keys=Object.keys(data.Rows);
        for(let i=0;i<data.Columns.length;i++) {
            let m=new Date(this.getYear(),i,1);
            let t={m:m.getFullYear()+'-'+Number(m.getMonth()+1)};
            for(let n=0;n<this.keys.length;n++) {
                t[this.keys[n]]=data.Rows[this.keys[n]][i];
            }
            res.push(t);
        }
        return res;
    }

    getYear() {
        let d=new Date();
        return d.getFullYear();
    }

    getColor() {
        return ['#007bff','#6610f2','#6f42c1','#e83e8c','#dc3545','#fd7e14','#ffc107','#28a745','#20c997',
                '#17a2b8','#6c757d','#343a40','#007bff','#6c757d','#28a745','#17a2b8','#ffc107','#dc3545',
                '#f8f9fa','#343a40'];
    }

    getConfig(chartName) {
        let Conf={
            'Morris':{
                element: 'chart',
                data: this.dataChart,
                xLabels: 'month',
                xkey: 'm',
                ykeys: this.keys,
                xLabelFormat: function(x) {
                    let month = this.months[new Date(x.label).getMonth()];
                    return month;
                },
                dateFormat: function(x) {
                    let month = this.months[new Date(x).getMonth()];
                    return month;
                },
                labels: this.keys,
                lineColors: ['red', 'blue','gray','black','orange'],
                hideHover: 'auto',
                months:this.months,
            },
        };
        return Conf[chartName];
    }

    async saveConfig(param,e) {
        let body={name:chart,'conf':param};
        let response = await fetch(
                '/en/Index/saveGraphConfig',
                {
                    method:'POST',
                    body:JSON.stringify(body),
                });
        let data = await response.json();
        d.getElementById('Msg').textContent=data.msg;
        d.getElementsByClassName('afeedback')[0].click();
        console.log(data);
    }
}

/*
 * @description creating a table with data
 * @param object data {Colums: array, Rows: object {string: array}}
 * @param object attr {table: object {string:object}, thead:object {string:object}}
 */
class Table {

    constructor(data,attr) {
        this.attr=attr;
        this.thead=this.createHeadTable(data.Columns);
        this.tbody=this.createBodyTable(data.Rows);
        this.table= new Element({tag:'table', attr:this.attr.table});
        this.table.appendChild(this.thead);
        this.table.appendChild(this.tbody);
        return this.table;
    }
    createHeadTable(columns) {
        let tHead=new Element({tag:'thead', attr:this.attr.thead});
        let Tr=new Element({tag:'tr'});
        tHead.appendChild(Tr);
        Tr.appendChild(new Element({tag:'th'}));
        for(let i=0;i<columns.length;i++) {
            let th=new Element({tag:'th'});
            th.textContent=columns[i];
            Tr.appendChild(th);
        }
        return tHead;
    }
    createBodyTable(rows) {
        let tBody=new Element({tag:'tbody'});
        for(let key in rows ) {
            let Tr=new Element({tag:'tr'});
            let td=new Element({tag:'td'});
            td.textContent=key;
            Tr.appendChild(td);
            for(let i=0;i<rows[key].length;i++) {
                let td=new Element({tag:'td'});
                td.textContent=rows[key][i];
                Tr.appendChild(td);
            }
            tBody.appendChild(Tr);
        }
        return tBody;
    }
}

/*
 * @description creating new doсument element
 * @param object {tag: @type string, attr: @type object {string: string object}}
 */
class Element {
    constructor(o) {
        this.tag=o.tag;
        this.attr=o.attr;
        return this.create();
    }

   create() {
        var elem=document.createElement(this.tag);
        for (var key in this.attr) {
            elem.setAttribute(key,
                              (key!='style')?this.attr[key]:this.setStyle(this.attr[key])
                              );
        }
    return elem;
    }

    setStyle(args) {
    var style=[];
        for (var css in args) {
          style.push(css+':'+args[css])
        }
        return style.join(';');
    }
}

/*
 * @description adding to element by class name
 * @param object element
 * @param stirng  target classname
 */
class AddToElementByClassName {
    constructor(element,target) {
        this.Traget=document.getElementsByClassName(target)[0];
        this.Traget.appendChild(element);
    }
}

/*
 * @description adding to element by Id
 * @param object element
 * @param stirng  target Id
 */
class AddToElementById {
    constructor(element,target) {
        this.Traget=document.getElementById(target);
        this.Traget.appendChild(element);
    }
}