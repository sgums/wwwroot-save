USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[llu_desktop_bottom]    Script Date: 1/30/2017 3:50:43 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO









CREATE procedure [dbo].[llu_desktop_bottom] (@grpName varchar(20))
as

--declare @grpName varchar(20);
--set @grpName = 'operations';


select top 7
logid,
name,
worksplit,
workmode,
agtime,
cast((cast((agtime) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((agtime) as int)%60) as varchar(2)),2) as statetime
from rt_agent
where split in (select split from split_groups where param=@grpName)
and (workmode='ACD' and direction='IN' and agtime > 900) or (workmode='OTHER' and agtime > 300)
	or (workmode like '%HOLD%' and agtime > 180)
group by logid, name, worksplit, workmode, agtime
order by workmode desc, agtime desc





GO

