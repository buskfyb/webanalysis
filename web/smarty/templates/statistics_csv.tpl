libraryname{"\t"}ID{"\t"}population{"\t"}Besøk{"\t"}Periode{"\t"}visitors{"\t"}Sidevisninger{"\t"}visit_time{"\t"}Frafallsprosent{"\t"}visits_per_pop{"\t"}Endring prosent{"\t"}Sider per besøk{"\t"}category
{strip}
{foreach from=$data item=site}
 {foreach from=$site item=line}
  {foreach from=$line item=e}
   {$e}{"\t"}
  {/foreach}{"\n"}
 {/foreach}
{/foreach}
{/strip}
