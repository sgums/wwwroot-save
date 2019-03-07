USE [cms]
GO

/****** Object:  StoredProcedure [dbo].[medline_desktop_bottom]    Script Date: 1/11/2017 7:46:11 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO




CREATE procedure [dbo].[medline_desktop_bottom] (@grpName nchar(30))
as

--declare @grpName nchar(30);
--set @grpName = 'IT_Help_Desk';


select
logid,
name,
worksplit,
workmode,
duration
from rt_agent
where split in (select split from split_groups where group_name=@grpName)
group by logid, name, worksplit, workmode, duration

GO

