USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[importLastInterval]    Script Date: 1/30/2017 3:50:20 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO





CREATE procedure [dbo].[importLastInterval]
as

declare @offset int
set @offset = 0; --Used to adjust the hours difference between the Database and CMS.

declare @table varchar(15);

declare @lastIntervalDate datetime;
select @lastIntervalDate = dbo.getLastInterval(@offset);

declare @lastInterval varchar(5);
select @lastInterval = DATEPART(HOUR,@lastIntervalDate) * 100 + DATEPART(MINUTE,@lastIntervalDate);

declare @rowDate varchar(20);
select @rowDate = convert (varchar,@lastIntervalDate,101);

declare @qry varchar(MAX);
declare @TSQL varchar(max);

set @table = 'hsplit';
select @qry = 'SELECT row_date,split,starttime,callsoffered,acdcalls,abncalls,acceptable,acdtime FROM ' + @table +' WHERE row_date=''''' + 
	@rowDate + ''''' and starttime=' + @lastInterval;
select @TSQL = 'INSERT INTO split_history (row_date,split,starttime,callsoffered,acdcalls,abncalls,acceptable,acdtime) SELECT * FROM openquery(cms,''' + @qry + ''')';

--select @TSQL;
EXEC (@TSQL);



GO

