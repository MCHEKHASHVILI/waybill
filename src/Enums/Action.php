<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Enums;

enum Action: string
{
    case CHECK_SERVICE_USER = "chek_service_user";
    case CLOSE_WAYBILL = "close_waybill";
    case CLOSE_WAYBILL_TRANSPORTER = "close_waybill_transporter";
    case CLOSE_WAYBILL_vd = "close_waybill_vd";
    case CONFIRM_WAYBILL = "confirm_waybill";
    case CREATE_SERVICE_USER = "create_service_user";
    case DELETE_WAYBILL = "del_waybill";
    case DELETE_BAR_CODE = "delete_bar_code";
    case DELETE_CAR_NUMBERS = "delete_car_numbers";
    case DELETE_WAYBILL_TEMPLATE = "delete_waybill_tamplate";
    case GET_ADJUSTED_WAYBILL = "get_adjusted_waybill";
    case GET_ADJUSTED_WAYBILLS = "get_adjusted_waybills";
    case GET_EXCISE_CODES = "get_akciz_codes";
    case GET_BAR_CODES = "get_bar_codes";
    case GET_BUYER_WAYBILL_GOODS_LIST = "get_buyer_waybilll_goods_list";
    case GET_BUYER_WAYBILLS = "get_buyer_waybills";
    case GET_BUYER_WAYBILLS_EX = "get_buyer_waybills_ex";
    case GET_C_WAYBILL = "get_c_waybill";
    case GET_CAR_NUMBERS = "get_car_numbers";
    case GET_ERROR_CODES = "get_error_codes";
    case GET_NAME_FROM_TIN = "get_name_from_tin";
    case GET_PAYER_TYPE_FROM_UN_ID = "get_payer_type_from_un_id";
    case GET_PRINT_PDF = "get_print_pdf";
    case GET_SERVER_TIME = "get_server_time";
    case GET_SERVICE_USERS = "get_service_users";
    case GET_TIN_FROM_UN_ID = "get_tin_from_un_id";
    case GET_TRANS_TYPES = "get_trans_types";
    case GET_TRANSPORTER_WAYBILLS = "get_transporter_waybills";
    case GET_WAYBILL = "get_waybill";
    case GET_WAYBILL_BY_NUMBER = "get_waybill_by_number";
    case GET_WAYBILL_GOODS_LIST = "get_waybill_goods_list";
    case GET_WAYBILL_TEMPLATE = "get_waybill_tamplate";
    case GET_WAYBILL_TEMPLATES = "get_waybill_tamplates";
    case GET_WAYBILL_TYPES = "get_waybill_types";
    case GET_WAYBILL_UNITS = "get_waybill_units";
    case GET_WAYBILLS = "get_waybills";
    case GET_WAYBILLS_EX = "get_waybills_ex";
    case GET_WAYBILLS_MEDICAMENTS_MOH = "get_waybills_medicaments_moh";
    case GET_WAYBILLS_V1 = "get_waybills_v1";
    case GET_WOOD_TYPES = "get_wood_types";
    case IS_VAT_PAYER = "is_vat_payer";
    case IS_VAT_PAYER_TIN = "is_vat_payer_tin";
    case REF_WAYBILL = "ref_waybill";
    case REF_WAYBILL_VD = "ref_waybill_vd";
    case REJECT_WAYBILL = "reject_waybill";
    case SAVE_BAR_CODE = "save_bar_code";
    case SAVE_CAR_NUMBERS = "save_car_numbers";
    case SAVE_INVOICE = "save_invoice";
    case SAVE_WAYBILL = "save_waybill";
    case SAVE_WAYBILL_TEMPLATE = "save_waybill_tamplate";
    case SAVE_WAYBILL_TRANSPORTER = "save_waybill_transporter";
    case SEND_WAYBILL_VD = "send_waybil_vd";
    case SEND_WAYBILL = "send_waybill";
    case SEND_WAYBILL_TRANSPORTER = "send_waybill_transporter";
    case UPDATE_SERVICE_USER = "update_service_user";
    case WHAT_IS_MY_IP = "what_is_my_ip";
}
