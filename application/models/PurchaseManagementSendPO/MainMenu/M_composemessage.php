<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_composemessage extends CI_Model
{
    function __construct()
    {
				parent::__construct();
				$this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
    }

		public function getEmailAddress($id)
		{
				$sql =
						"SELECT NVL(
              (SELECT DISTINCT hps.attribute16 email
                           FROM po_headers_all poh,
                                ap_supplier_sites_all vs,
                                hz_party_sites hps
                          WHERE vs.vendor_site_id = poh.vendor_site_id
                            AND vs.party_site_id = hps.party_site_id
                            AND poh.segment1 = $id),
							(SELECT *
							FROM
							(SELECT
									ksea.EMAIL
							 FROM
									po_headers_all pha,
									khs_supplier_email_account ksea
							 WHERE
									pha.VENDOR_ID = ksea.VENDOR_ID
									AND pha.SEGMENT1 = $id)
							WHERE ROWNUM <= 1)) email FROM dual
						";
				$query = $this->oracle->query($sql);
				return $query->result_array();
		}

    //EMAIL ADDRESS PO UNITY KUBOTA
    public function getEmailAddressGabungan($id)
		{
				$sql =
						"select distinct hps.ATTRIBUTE16 EMAIL
              from PO_HEADERS_ALL poh, ap_supplier_sites_all vs, HZ_PARTY_SITES hps,
                   (SELECT po_unity_number , po_num
                      from (SELECT kppu.po_unity_id, po_unity_number, po_num01 po_num
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num02
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num03
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num04
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num05
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num06
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num07
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num08
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num09
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num10
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num11
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num12
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num13
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num14
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                            UNION
                            SELECT kppu.po_unity_id, po_unity_number, po_num15
                              FROM apps.khs_pur_po_unity kppu
                             WHERE kppu.po_unity_number = '$id'
                             ) kppu
                   )po_unity
              where vs.VENDOR_SITE_ID=poh.VENDOR_SITE_ID
                AND VS.PARTY_SITE_ID = HPS.PARTY_SITE_ID
                and poh.segment1 = po_unity.po_num
						";
				$query = $this->oracle->query($sql);
				return $query->result_array();
		}


    public function getVendorSite($id)
		{
				$sql =
						"select distinct vs.vendor_site_code site
                from PO_HEADERS_ALL poh, ap_supplier_sites_all vs,
                     (SELECT po_unity_number , po_num
                        from (SELECT kppu.po_unity_id, po_unity_number, po_num01 po_num
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num02
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num03
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num04
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num05
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num06
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num07
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num08
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num09
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num10
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num11
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num12
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num13
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num14
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                              UNION
                              SELECT kppu.po_unity_id, po_unity_number, po_num15
                                FROM apps.khs_pur_po_unity kppu
                               WHERE kppu.po_unity_number = '$id'
                               ) kppu
                     )po_unity
                where vs.VENDOR_SITE_ID=poh.VENDOR_SITE_ID
                  and poh.segment1 = po_unity.po_num
						";
				$query = $this->oracle->query($sql);
				return $query->result_array();
		}


    // PO NUMBER UNTUK PO UNITY KUBOTA
    public function getPONumber($id)
		{
				$sql =
						"     SELECT po_unity_number , po_num
                    from         (SELECT kppu.po_unity_id, po_unity_number, po_num01 po_num
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num02
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num03
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num04
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num05
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num06
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num07
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num08
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num09
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num10
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num11
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num12
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num13
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num14
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id'
                                  UNION
                                  SELECT kppu.po_unity_id, po_unity_number, po_num15
                                    FROM apps.khs_pur_po_unity kppu
                                   WHERE kppu.po_unity_number = '$id') kppu
              WHERE PO_NUM IS NOT NULL
						";
				$query = $this->oracle->query($sql);
				return $query->result_array();
		}

		public function getDeliveryLetters($id)
		{
				$sql =
						"SELECT DISTINCT   (SELECT count(pll2.rowid)+1 FROM PO_LINE_LOCATIONS_ALL pll2
                                        WHERE pll2.LINE_LOCATION_ID<pll.LINE_LOCATION_ID
                                        AND pll2.PO_HEADER_ID=poh.PO_HEADER_ID AND NVL(pll2.CANCEL_FLAG,'N')='N'
                                ) nomor,
                                v.VENDOR_NAME COMPANY_NAME,
                                vs.VENDOR_SITE_CODE SITE,
                                pl.LINE_NUM ,
                                (SELECT max(kds.ADDRESS_DETAIL_INT) FROM KHS_DATA_SUPPLIER kds WHERE kds.VENDOR_ID=poh.VENDOR_ID AND kds.vendor_site_id=poh.vendor_site_id) ADDRESS,
                                (SELECT max(kds.PHONE_NUMBER) FROM KHS_DATA_SUPPLIER kds WHERE kds.VENDOR_ID=poh.VENDOR_ID AND kds.vendor_site_id=poh.vendor_site_id) PHONE_NUMBER,
--                                CASE
--                                        WHEN (SELECT kse.EMAIL FROM khs_supplier_email_account kse WHERE kse.VENDOR_ID(+) = poh.VENDOR_ID AND kse.KODE = 'HZ_PARTIES') IS NULL
--                                                THEN (SELECT kse.EMAIL FROM khs_supplier_email_account kse WHERE kse.VENDOR_ID(+) = poh.VENDOR_ID AND kse.KODE = 'HZ_PARTY_SITES')
--                                        ELSE (SELECT kse.EMAIL FROM khs_supplier_email_account kse WHERE kse.VENDOR_ID(+) = poh.VENDOR_ID AND kse.KODE = 'HZ_PARTIES')
--                                END EMAIL_ADDRESS,
                                (SELECT DISTINCT hps_mail.attribute16 email
                                            FROM po_headers_all poh_mail,
                                                 ap_supplier_sites_all vs_mail,
                                                 hz_party_sites hps_mail
                                           WHERE vs_mail.vendor_site_id = poh_mail.vendor_site_id
                                             AND vs_mail.party_site_id = hps_mail.party_site_id
                                             AND poh_mail.segment1 = poh.segment1) EMAIL_ADDRESS,
                               (CASE
                                WHEN v.vendor_name = 'HONDA POWER PRODUCTS INDONESIA, PT'
                                THEN (SELECT Contact_name FROM KHS_SUP_CONTACT WHERE org_name=v.VENDOR_NAME AND contact_party_id=
                                        (SELECT max(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua
                                        WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID AND hpua.EFFECTIVE_END_DATE > SYSDATE
                                        AND hpua.PARTY_USAGE_CODE = 'SUPPLIER_CONTACT' AND org_name=v.VENDOR_NAME))
                                ELSE
                                        (SELECT Contact_name FROM KHS_SUP_CONTACT WHERE org_name=v.VENDOR_NAME AND contact_party_id=
                                        (SELECT min(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua
                                        WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID AND hpua.EFFECTIVE_END_DATE > SYSDATE
                                        AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name=v.VENDOR_NAME))
                                END
                                || decode((SELECT count(*) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua
                                        WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID AND hpua.EFFECTIVE_END_DATE > SYSDATE
                                        AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name=v.VENDOR_NAME),1,'',
                                        decode((SELECT distinct Contact_name FROM KHS_SUP_CONTACT WHERE org_name=v.VENDOR_NAME AND contact_party_id=
                                        (SELECT min(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua
                                        WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID
                                        AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name=v.VENDOR_NAME AND contact_party_id>
                                        (SELECT min(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua
                                        WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID
                                        AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name=v.VENDOR_NAME))),null,'',
                                        ' / '||(SELECT distinct Contact_name FROM KHS_SUP_CONTACT WHERE org_name=v.VENDOR_NAME AND contact_party_id=
                                        (SELECT min(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua
                                        WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID
                                        AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name=v.VENDOR_NAME AND contact_party_id>
                                        (SELECT min(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua
                                        WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID
                                        AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name=v.VENDOR_NAME)))))
                                ) PERSON_IN_CHARGE,
                                poh.SEGMENT1 NO_PO,
                                poh.REVISION_NUM REV_NUM,
                                pll.QUANTITY QTY_PLAN,
                                decode(uom.UOM_CODE,'UNT','UNIT',uom.UOM_CODE) UOM_CODE,
                                SUBSTR (msi.segment1, 1, 40)Kode_Barang,
                                pl.item_description,
                                pl.note_to_vendor keterangan
                          FROM PO_VENDORS v,
                               PO_VENDOR_SITES_ALL vs,
                               PO_HEADERS_ALL poh,
                               PO_LINE_LOCATIONS_ALL pll,
                               MTL_SYSTEM_ITEMS_FVL msi,
                               mtl_units_of_measure_tl uom,
                               PO_LINES_ALL pl
                         WHERE pll.cancel_date IS NULL AND NVL(pl.CANCEL_FLAG,'N')='N'
                           AND poh.VENDOR_ID=v.VENDOR_ID
                           AND vs.VENDOR_SITE_ID=poh.VENDOR_SITE_ID
                           AND pl.PO_HEADER_ID=poh.PO_HEADER_ID
                           AND pll.PO_LINE_ID=pl.PO_LINE_ID
                           AND pll.PO_HEADER_ID=poh.PO_HEADER_ID
                           AND pl.ITEM_ID=msi.INVENTORY_ITEM_ID
                           AND pl.UNIT_MEAS_LOOKUP_CODE=uom.UNIT_OF_MEASURE
                           AND poh.segment1 = '$id'
                        Order By pl.LINE_NUM
						";
				$query = $this->oracle->query($sql);
				return $query->result_array();
		}

		public function getVendorName($id)
		{
				$sql = "SELECT DISTINCT
										pv.VENDOR_NAME
								FROM
										po_headers_all pha,
										po_vendors pv
								WHERE
										pv.VENDOR_ID = pha.VENDOR_ID
									AND
										pha.SEGMENT1 = $id
								";
				$query = $this->oracle->query($sql);
				return $query->result_array();
		}
    // PO UNITY KUBOTA
    public function getVendorNameGabungan($id)
    {
        $sql = "SELECT DISTINCT pv.vendor_name
                  FROM po_vendors pv
                 WHERE pv.vendor_id = 4066
                ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}
?>
