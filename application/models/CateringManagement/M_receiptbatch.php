<?php
class M_receiptbatch extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//select Receipt All
		public function GetReceipt(){
			$sql = "
			select *,
				case when a.receipt_date
				is NULL then null 	
				else to_char(a.receipt_date, 'DD MONTH YYYY')
				end as receipt_date,
				case when a.order_start_date
				is NULL then null 	
				else to_char(a.order_start_date, 'DD/MM/YYYY')
				end as order_start_date,
				case when a.order_end_date
				is NULL then null 	
				else to_char(a.order_end_date, 'DD/MM/YYYY')
				end as order_end_date
				
			from cm.cm_receipt a
			left join cm.cm_type b on a.order_type_id = b.type_id
			left join cm.cm_catering c on a.catering_id = c.catering_id
			where (
				select count(*)
				from cm.cm_receipt_qty d 
				where a.receipt_id = d.receipt_id
			) > 0
			order by a.receipt_id desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//Select Receipt Single
		public function GetReceiptDetails($id){
			$sql = "
			select *,
				case when a.receipt_date
				is NULL then null 	
				else to_char(a.receipt_date, 'DD MONTH YYYY')
				end as receipt_date,
				case when a.receipt_date
				is NULL then null 	
				else to_char(a.receipt_date, 'DD.MM.YYYY')
				end as short_receipt_date,
				case when a.order_start_date
				is NULL then null 	
				else to_char(a.order_start_date, 'DD/MM/YYYY')
				end as order_start_date,
				case when a.order_end_date
				is NULL then null 	
				else to_char(a.order_end_date, 'DD/MM/YYYY')
				end as order_end_date
				
			from cm.cm_receipt a
			left join cm.cm_type b on a.order_type_id = b.type_id
			left join cm.cm_catering c on a.catering_id = c.catering_id
			where a.receipt_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//Select Receipt Single
		public function GetReceiptForEdit($id){
			$sql = "
			select 	*
			from 	cm.cm_receipt a
			left 	join cm.cm_type b on a.order_type_id = b.type_id
			left 	join cm.cm_catering c on a.catering_id = c.catering_id
			where 	a.receipt_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//Select Receipt Fine Single
		public function GetReceiptFineForEdit($id){
			$sql = "
			select *
			from cm.cm_receipt_fine
			where receipt_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//Get Order Type List
		public function GetOrderType(){
			$sql = "select * from cm.cm_type order by type_description";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//Get Fine Type List
		public function GetFineType(){
			$sql = "select * from cm.cm_fine_type order by fine_type_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//Get Catering List
		public function GetCatering(){
			$sql = "select * from cm.cm_catering order by catering_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//Get Latest ID
		public function GetLatestId(){
			$sql = "select nextval('cm.cm_receipt_receipt_id_seq') as nextval from cm.cm_receipt order by receipt_id desc limit 1";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//Create New Receipt
		public function AddReceipt($id,$no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment,$menu,$bonus,$lokasi){
			$sql = "
			insert into cm.cm_receipt
			(receipt_id,receipt_no,receipt_date,receipt_place,receipt_from,receipt_signer,order_start_date,order_end_date,order_qty,order_price,fine,pph,payment,order_type_id,catering_id,order_description,bonus,kd_lokasi)values
			('$id','$no',TO_DATE('$date','YYYY-MM-DD'),'$place','$from','$signer','$startdate','$enddate','$orderqty','$orderprice','$fine','$pph','$payment','$ordertype','$catering','$menu','$bonus','$lokasi')";
			$query = $this->db->query($sql);
			return;
		}
		
		//Create New Fine
		public function AddReceiptFine($data){
			return $this->db->insert('cm.cm_receipt_fine', $data);
		}
		
		//Delete Receipt Fine
		public function DeleteReceiptFine($id){
			$sql = "delete from cm.cm_receipt_fine where receipt_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		//Update Receipt
		public function UpdateReceipt($id,$no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment,$menu,$bonus){
			$sql = "
			update cm.cm_receipt set 
				receipt_no='$no',
				receipt_date=TO_DATE('$date','YYYY-MM-DD'),
				receipt_place='$place',
				receipt_from='$from',
				receipt_signer='$signer',
				order_start_date='$startdate',
				order_end_date='$enddate',
				order_qty='$orderqty',
				order_price='$orderprice',
				fine='$fine',
				pph='$pph',
				payment='$payment',
				order_type_id='$ordertype',
				catering_id='$catering',
				order_description='$menu',
				bonus='$bonus'
			where receipt_id='$id'
			";
			$query = $this->db->query($sql);
			return;
		}
		
		//Delete Receipt
		public function DeleteReceipt($id){
			$sql = "delete from cm.cm_receipt where receipt_id='$id'
			";
			$query = $this->db->query($sql);
			return;
		}

		public function DeleteReceiptQty($id){
			$sql = "delete from cm.cm_receipt_qty where receipt_id='$id'
			";
			$query = $this->db->query($sql);
			return;
		}
		
		public function GetPphStatus($id){
			$sql = "select * from cm.cm_catering where catering_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function GetFineValue($id){
			$sql = "select * from cm.cm_fine_type where fine_type_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function getCateringKode($id){
			$sql = "select *
					from cm.cm_catering
					where catering_id = ?";
			$result = $this->db->query($sql,array($id))->row();
			if (!empty($result)) {
				return $result->catering_code;
			}else{
				return 'nan';
			}
		}

		public function getDeptQty($tgl_awal,$tgl_akhir,$lokasi,$jenis_pesanan,$katering){
			$sql = "select gabung,
						sum(
							case when dept = 'KEUANGAN' then jumlah else 0 end 
						) as keuangan,
						sum(
							case when dept = 'PEMASARAN' then jumlah else 0 end 
						) as pemasaran,
						sum(
							case when dept = 'PRODUKSI' then jumlah else 0 end 
						) as produksi,
						sum(
							case when dept = 'PERSONALIA' then jumlah else 0 end 
						) as personalia
					from (
						select '1'::varchar as gabung, tph.fs_tempat_makan,
							sum(fn_jumlah_pesan) as jumlah,
							coalesce((
								select
									trim(ts.dept) as dept
								from hrd_khs.tpribadi tp
								left join hrd_khs.tseksi ts
								on tp.kodesie = ts.kodesie
								where tp.keluar = '0'
								and tp.lokasi_kerja in ('01','02','03','04')
								and trim(tp.tempat_makan) = trim(tph.fs_tempat_makan)
								group by trim(tp.tempat_makan),trim(ts.dept)
								order by 1 desc 
								limit 1
							), 'PERSONALIA')::varchar as dept
						from \"Catering\".tpesanan_history tph 
						inner join \"Catering\".turutankatering tuk
						on tph.fd_tanggal = tuk.fd_tanggal
						and tph.fs_tanda = tuk.fn_urutan::varchar
						inner join \"Catering\".ttempat_makan ttm 
						on tph.fs_tempat_makan = ttm.fs_tempat_makan
						where tph.fd_tanggal between ? and ?
						and tph.lokasi = ?
						and tph.jenis_pesanan = ?
						and tuk.fs_nama_katering = (
							select tk.fs_nama_katering
							from \"Catering\".tkatering tk
							where tk.fs_kd_katering = ?
							)
						group by tph.fs_tempat_makan
					) as tbl 
					group by gabung";
			$this->personalia = $this->load->database('personalia', true);
			return $this->personalia->query($sql,array($tgl_awal,$tgl_akhir,$lokasi,$jenis_pesanan,$katering))->row();
		}

		public function addReceiptQty($data){
			$this->db->insert('cm.cm_receipt_qty',$data);
		}

		public function GetReceiptQty($id){
			$sql = "select *
					from cm.cm_receipt_qty 
					where receipt_id = ?";
			return $this->db->query($sql, array($id))->result_array();
		}
		
}
?>