libraryname{"\t"}siteid{"\t"}population{"\t"}visits{"\t"}period{"\t"}visitors{"\t"}pageviews{"\t"}visit_time{"\t"}bounce_rate{"\t"}visits_per_pop{"\t"}change_percent{"\t"}pages_per_visist{"\t"}category
{strip}
{foreach from=$data item=site}
 {foreach from=$site item=line}
  {foreach from=$line item=e}
   {$e}{"\t"}
  {/foreach}{"\n"}
 {/foreach}
{/foreach}
{/strip}
