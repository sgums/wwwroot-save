USE [tester]
GO

/****** Object:  StoredProcedure [dbo].[web_report_view]    Script Date: 8/29/2015 7:22:01 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

create procedure [dbo].[web_report_view]
as


SELECT
	split,
	splitname,
	skstate,
	staffed,
	waiting,	
	cast((cast(oldest as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(oldest as int)%60) as varchar(2)),2) as oldest,
	acdcalls,
	case 
		when acdcalls = 0 then '0:00'
	else 	 
		cast((cast((acdtime/acdcalls) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((acdtime/acdcalls) as int)%60) as varchar(2)),2)
	end as AvgTalkTime,
	abncalls,
	case
		when abncalls = 0 then '0:00'
	else
		cast((cast((abntime/abncalls) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((abntime/abncalls) as int)%60) as varchar(2)),2)		
	end as AvgAbnTime,
	case
		when acdcalls = 0 then '0:00'
	else
		cast((cast((anstime/acdcalls) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((anstime/acdcalls) as int)%60) as varchar(2)),2)		
	end as ASA
FROM rt_split


GO

