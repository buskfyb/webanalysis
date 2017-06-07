libraryname;siteid;population;visits;period;visitors;pageviews;visit_time;bounce_rate;visits_per_pop;change_percent;pages_per_visist;category
{foreach from=$data item=site}
 {foreach from=$site item=line}
{strip}
  {foreach from=$line item=e}
   {$e};
  {/foreach}
{/strip}
 {/foreach}
{/foreach}
