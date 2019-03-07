USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[agent_count_chart]    Script Date: 1/30/2017 3:49:55 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO





CREATE procedure [dbo].[agent_count_chart] (@grp varchar(20))
as 

--declare @grp varchar(20)
--set @grp='operations';


select
max(available) as available,
max(onacd) as onacd,
max(inacw) as inacw,
max(inaux) as inaux,
max(other) as other
from rt_split 
where split in (select split from split_groups where param=@grp)




GO

