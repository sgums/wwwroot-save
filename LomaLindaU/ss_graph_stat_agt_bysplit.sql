USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[ss_graph_stat_agt_bysplit]    Script Date: 1/30/2017 3:53:09 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO






CREATE procedure [dbo].[ss_graph_stat_agt_bysplit] (@spl int)
as

select
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
duration as duration_seconds,
cast((cast(duration as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(duration as int)%60) as varchar(2)),2) as duration,
direction as direction,
worksplit,
skill_level
from rt_agent
where 
split=@spl and workmode='ACW'
order by duration desc







GO

