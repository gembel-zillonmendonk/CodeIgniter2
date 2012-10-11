-- todo list

select b.login_id, a.* from vw_ext_todo a
inner join vnd_header b on a.vendor_id = b.vendor_id

-- view

exec sp_executesql N'
				SET ANSI_NULLS OFF
				
				SELECT
					[ptp_id],
					[ptm_number],
					[ptp_tender_method],
					[ptp_justification],
					[ptp_submission_method],
					[ptp_evaluation_method],
					[ptp_reg_opening_date],
					[ptp_reg_closing_date],
					[ptp_prebid_date],
					[ptp_prebid_location],
					[ptp_quot_closing_date],
					[ptp_tech_bid_date],
					[ptp_comm_bid_date],
					[ptp_delivery_point_id],
					[ptp_delivery_point],
					[ptp_inquiry_notes],
					[ptp_enabled_rank],
					[ptp_prequalify],
					[ptp_preq_open_date],
					[ptp_preq_closing_date],
					[evt_id],
					[evt_description],
					[adm_bid_committee],
					[adm_bid_committee_name],
					[ppt_id],
					[ppt_name],
					[ptp_bid_opening2],
					[ptp_tgl_aanwijzing2],
					[ptp_lokasi_aanwijzing2],
					[Ptp_Klasifikasi_Peserta]
				FROM
					[dbo].[prc_tender_prep]
				WHERE
					[ptm_number] = @Ptm_Number
				
				Select @@ROWCOUNT
				SET ANSI_NULLS ON
			',N'@Ptm_Number varchar(4)',@Ptm_Number='1021'

exec sp_executesql N'
				
				BEGIN

				-- Build the sql query
				declare @SQL as nvarchar(4000)
				SET @SQL = '' SELECT * FROM [dbo].[vw_ext_quotation_header]''
				IF LEN(@WhereClause) > 0
				BEGIN
					SET @SQL = @SQL + '' WHERE '' + @WhereClause
				END
				IF LEN(@OrderBy) > 0
				BEGIN
					SET @SQL = @SQL + '' ORDER BY '' + @OrderBy
				END
				
				-- Execution the query
				exec sp_executesql @SQL
				
				-- Return total count
				Select @@ROWCOUNT as TotalRowCount
				
				END
			',N'@WhereClause nvarchar(45),@OrderBy nvarchar(4000)',@WhereClause=N'ptm_number = ''1021'' and ptv_vendor_code = ''6''',@OrderBy=N''

exec sp_executesql N'
				SELECT
					[ptm_number],
					[ptm_upreff],
					[ptm_downreff],
					[ptm_requester_name],
					[ptm_requester_pos_code],
					[ptm_requester_pos_name],
					[ptm_comm_sp_name],
					[ptm_comm_sp_pos_code],
					[ptm_comm_sp_pos_name],
					[ptm_vendor_sp_name],
					[ptm_vendor_sp_pos_code],
					[ptm_vendor_sp_pos_name],
					[ptm_created_date],
					[ptm_subject_of_work],
					[ptm_scope_of_work],
					[ptm_district_id],
					[ptm_district],
					[ptm_delivery_point_id],
					[ptm_delivery_point],
					[ptm_delivery_time],
					[ptm_delivery_unit],
					[ptm_buyer],
					[ptm_buyer_pos_code],
					[ptm_buyer_pos_name],
					[ptm_currency],
					[ptm_contract_type],
					[ptm_last_participant],
					[ptm_last_participant_code],
					[ptm_is_contract_created],
					[ptm_rfq_no],
					[ptm_status],
					[ptm_completed_date],
					[ptm_tender_id],
					[ptm_is_manual],
					[ptm_dept_id],
					[ptm_dept_name],
					[ptm_mata_anggaran],
					[ptm_nama_mata_anggaran],
					[ptm_sub_mata_anggaran],
					[ptm_nama_sub_mata_anggaran],
					[ptm_pagu_anggaran],
					[ptm_sisa_anggaran]
				FROM
					[dbo].[prc_tender_main]
				WHERE
					[ptm_number] = @Ptm_Number
			Select @@ROWCOUNT
					
			',N'@Ptm_Number varchar(4)',@Ptm_Number='1021'


exec sp_executesql N'
				
				BEGIN

				-- Build the sql query
				declare @SQL as nvarchar(4000)
				SET @SQL = '' SELECT * FROM [dbo].[vw_ext_quotation_eval]''
				IF LEN(@WhereClause) > 0
				BEGIN
					SET @SQL = @SQL + '' WHERE '' + @WhereClause
				END
				IF LEN(@OrderBy) > 0
				BEGIN
					SET @SQL = @SQL + '' ORDER BY '' + @OrderBy
				END
				
				-- Execution the query
				exec sp_executesql @SQL
				
				-- Return total count
				Select @@ROWCOUNT as TotalRowCount
				
				END
			',N'@WhereClause nvarchar(49),@OrderBy nvarchar(4000)',@WhereClause=N'ptm_number = ''1021'' and isnull(pqt_weight, 0) = 0',@OrderBy=N''

exec sp_executesql N'
				
				BEGIN

				-- Build the sql query
				declare @SQL as nvarchar(4000)
				SET @SQL = '' SELECT * FROM [dbo].[vw_ext_quotation_eval]''
				IF LEN(@WhereClause) > 0
				BEGIN
					SET @SQL = @SQL + '' WHERE '' + @WhereClause
				END
				IF LEN(@OrderBy) > 0
				BEGIN
					SET @SQL = @SQL + '' ORDER BY '' + @OrderBy
				END
				
				-- Execution the query
				exec sp_executesql @SQL
				
				-- Return total count
				Select @@ROWCOUNT as TotalRowCount
				
				END
			',N'@WhereClause nvarchar(50),@OrderBy nvarchar(4000)',@WhereClause=N'ptm_number = ''1021'' and isnull(pqt_weight, 0) <> 0',@OrderBy=N''

exec sp_executesql N'
				
				BEGIN

				-- Build the sql query
				declare @SQL as nvarchar(4000)
				SET @SQL = '' SELECT * FROM [dbo].[vw_ext_tender_item]''
				IF LEN(@WhereClause) > 0
				BEGIN
					SET @SQL = @SQL + '' WHERE '' + @WhereClause
				END
				IF LEN(@OrderBy) > 0
				BEGIN
					SET @SQL = @SQL + '' ORDER BY '' + @OrderBy
				END
				
				-- Execution the query
				exec sp_executesql @SQL
				
				-- Return total count
				Select @@ROWCOUNT as TotalRowCount
				
				END
			',N'@WhereClause nvarchar(19),@OrderBy nvarchar(4000)',@WhereClause=N'ptm_number = ''1021''',@OrderBy=N''


exec sp_executesql N'
				
				BEGIN

				-- Build the sql query
				declare @SQL as nvarchar(4000)
				SET @SQL = '' SELECT * FROM [dbo].[vw_ext_tender_vendor_status]''
				IF LEN(@WhereClause) > 0
				BEGIN
					SET @SQL = @SQL + '' WHERE '' + @WhereClause
				END
				IF LEN(@OrderBy) > 0
				BEGIN
					SET @SQL = @SQL + '' ORDER BY '' + @OrderBy
				END
				
				-- Execution the query
				exec sp_executesql @SQL
				
				-- Return total count
				Select @@ROWCOUNT as TotalRowCount
				
				END
			',N'@WhereClause nvarchar(43),@OrderBy nvarchar(4000)',@WhereClause=N'ptm_number = ''1021'' and Pvs_Vendor_Code = 6',@OrderBy=N''
			
			
-- table target
select * from prc_tender_quo_main
select * from prc_tender_quo_item
select * from prc_tender_quo_tech