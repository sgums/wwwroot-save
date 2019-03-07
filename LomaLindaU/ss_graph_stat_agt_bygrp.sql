USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[ss_graph_stat_agt_bygrp]    Script Date: 1/30/2017 3:52:46 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO








CREATE procedure [dbo].[ss_graph_stat_agt_bygrp] (@grp varchar(20))
as

--declare @grp varchar(20);
--set @grp='operations';

select top 15
name,
case 
	when workmode = 'AVAIL' then 'Available'
	when workmode = 'ACD' then 'On ACD'
	when workmode = 'ACW' then 'In ACW'
	when workmode = 'OTHER' then 'Other'	
	when workmode = 'AUX' then 
		CASE
		  when aux_reason = '0' then 'Aux 0'
		  else aux_reason
		 end
	else 'Unknown'
end as workmode,

--I understood it as current acw time and not daily totals.  The field was duration by changed to acw time
--was max(duration) now sum(acwtime) - didn't change the as so the php wasn't changed.
sum(acwtime) as duration_seconds,
cast((cast(sum(acwtime) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(sum(acwtime) as int)%60) as varchar(2)),2) as duration

from rt_agent
where 
split in (select split from split_groups where param=@grp) and acwtime > 0

group by name, workmode, aux_reason
having sum(acwtime) < 1800
order by sum(acwtime) , name









GO

