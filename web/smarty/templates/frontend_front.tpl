{include file="frontend_header.tpl"}

<div class="velg-aar">
<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> <strong>Velg år:</strong>
<select name="year" id="year" onchange="loadData('year')">
{section name=year start=$startYear loop=$thisYear+1 step=1}
 <option value="{$smarty.section.year.index}" {if $smarty.section.year.index == $currentYear}SELECTED{/if}>{$smarty.section.year.index}</option>
{/section}
</select>
</div>

<div class="velg-aar">
<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> <strong>Velg kategori:</strong>
<select name="category" id="category" onchange="loadData('category')">
<option value="0">Alle bibliotek</option>
{foreach from=$categories item=c}
 <option value="{$c.id}" {if $category == $c.id}SELECTED{/if}>{$c.name}</option>
{/foreach}
</select>
</div>


<div class="center">
<nav class="btn-group graph-selector" aria-label="velg-graf">
<a href="javascript:setField('average')" class="btn btn-default" role="button">Besøk per 1000</a>
<a href="javascript:setField('visits')" class="btn btn-default" role="button">Besøk totalt</a>
<a href="javascript:setField('visitors')" class="btn btn-default" role="button">Unike besøkende</a>
<a href="javascript:setField('bounce_rate')" class="btn btn-default" role="button">Fluktfrekvens i %</a>
<a href="javascript:setField('pageviews')" class="btn btn-default" role="button">Sidevisninger</a>
<a href="javascript:setField('pageviews_per_visit')" class="btn btn-default" role="button">Sider pr besøk</a>
</nav>
</div>
</div> {* end content-container *}

<div style="position: relative">
<div class="scroll-container">
	<div id="curve_chart"></div>
</div>
</div>


<div class="container-fluid">

<div style="float:right;"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> <a href="http://statistikk.webloft.no​" target=_blank" class="clear">Hjelp</a></div>

<div class="table-selector">
Måned: 
<select name="period" onchange="loadData('month')" id="month">
 <option value="1">Velg måned</option>
{section name=mnd start=1 loop=12 step=1}
    <option value="{$smarty.section.mnd.index}" {if $smarty.section.mnd.index == $period && $period_type=='month'}SELECTED{/if}>{$monthNames[$smarty.section.mnd.index-1]}</option>
{/section}
</select>

- eller -

Uke: 
<select name="period" onchange="loadData('week')" id="week">
 <option value="1">Velg uke</option>
{section name=week start=1 loop=52 step=1}
    <option value="{$smarty.section.week.index}" {if $smarty.section.week.index == $period && $period_type=='week'}SELECTED{/if}>{$smarty.section.week.index}</option>
{/section}
</select>
</div>

<div class="table-responsive">
<table id="libraryTable" class="table table-striped display">
<thead>
        <tr>
            <th>Bibliotek</th>
            <th></th>
            <th>Unike besøkende</th>
            <th>Antall besøk</th>
            <th>Side- visninger</th>
            <th>Gj.snitt tid</th>
            <th>Flukt-frekvens i %</th>
            <th>Befolkning</th>
            <th>Besøk pr 1000 innbygger</th>
            <th>Sider pr besøk</th>
            <th>Endring i %</th>
            <th>Sammen- lign</th>
        </tr>
</thead>
<tbody>
{foreach from=$libraries item=l}
   <tr>
    <td><a href="index.php?libid={$l.siteid}&libname={$l.libraryname}">{$l.libraryname}</a></td>
    <td> {if $l.URL != ""}<a href="{$l.URL}" target=_blank><span class="glyphicon glyphicon-home" aria-hidden="true"></span>{/if}</td>
    <td>{$l.visitors}</td>
    <td>{$l.visits}</td>
    <td>{$l.pageviews}</td>
    <td>{$l.visit_time}</td>
    <td>{$l.bounce_rate}</td>
    <td>{$l.population}</td>
    <td>{$l.visits_per_pop}</td>
    <td>{$l.pages_per_visit|string_format:"%.2f"}</td>
    <td>{$l.change_percent}</td>
    <td><input type="checkbox" id="{$l.siteid}" onchange="checkLibrary({$l.siteid},'{$l.libraryname}')"></td>
   </tr>
{/foreach}
</tbody>
</table>
</div>
{literal}
<script>
$(document).ready( function () {
    $('#libraryTable').DataTable();
} );
$('#libraryTable').DataTable( {
    "order": [],
    paging: false,
    "searching": false,
    "info": false,
    "columns": [
        null,
        {orderable: false},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-center', orderable: false}
      ]
} );

</script>
{/literal}

{include file="frontend_footer.tpl"}
