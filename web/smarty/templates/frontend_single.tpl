{include file="frontend_header.tpl"}

<span class="glyphicon glyphicon-menu-left" aria-hidden="true" style="font-size: 0.8rem"></span> <a href="/">tilbake</a>


<h1>{$start_site_name}</h1>

<div class="velg-aar" style="margin-top: 1rem;">
<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> <strong>Velg år:</strong>
<select name="year" id="year" onchange="changeYearSingle({$start_site_id}, '{$start_site_name}')">
{section name=year start=$startYear loop=$thisYear+1 step=1}
 <option value="{$smarty.section.year.index}" {if $smarty.section.year.index == $currentYear}SELECTED{/if}>{$smarty.section.year.index}</option>
{/section}
</select>
</div>



<div class="center">
<div class="btn-group graph-selector" aria-label="velg-graf">
<a href="javascript:setField('average')" class="btn btn-default" role="button">Besøk per 1000</a>
<a href="javascript:setField('visits')" class="btn btn-default" role="button">Besøk totalt</a>
<a href="javascript:setField('visitors')" class="btn btn-default" role="button">Unike besøkende</a>
<a href="javascript:setField('bounce_rate')" class="btn btn-default" role="button">Fluktfrekvens i %</a>
<a href="javascript:setField('pageviews')" class="btn btn-default" role="button">Sidevisninger</a>
<a href="javascript:setField('pageviews_per_visit')" class="btn btn-default" role="button">Sider pr besøk</a>
</div>
</div>
</div> {* end content-container *}


<div style="position: relative">
<div class="scroll-container">
	<div id="curve_chart"></div>
</div>
</div>

<div class="container-fluid">
<div style="float:right;"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> <a href="http://statistikk.webloft.no​" target=_blank" class="clear">Hjelp</a></div>

<div class="table-single table-responsive">
<table id="libraryTable" class="table table-striped display">
<thead>
        <tr>
            <th>Uke</th>
            <th>Unike besøkende</th>
            <th>Antall besøk</th>
            <th>Side- visninger</th>
            <th>Gj.snitt tid</th>
            <th>Fluktfrekvens i %</th>
            <th>Befolkning</th>
            <th>Besøk pr 1000 innbygger</th>
            <th>Sider pr besøk</th>
            <th>Endring i %</th>
        </tr>
</thead>
<tbody>
{foreach from=$libraries item=l}
   <tr>
    <td>{$l.period}</td>
    <td>{$l.visitors}</td>
    <td>{$l.visits}</td>
    <td>{$l.pageviews}</td>
    <td>{$l.visit_time}</td>
    <td>{$l.bounce_rate}</td>
    <td>{$l.population}</td>
    <td>{$l.visits_per_pop}</td>
    <td>{$l.pages_per_visit|string_format:"%.2f"}</td>
    <td>{$l.change_percent}</td>
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
    "info": false,
    "columns": [
        null,
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'},
        {className: 'dt-body-right'}
      ],
      "bFilter": false,
    "language": {
        "search": "Søk"
    }      
} );

</script>
{/literal}

{include file="frontend_footer.tpl"}
