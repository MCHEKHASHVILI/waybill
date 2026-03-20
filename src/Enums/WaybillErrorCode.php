<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Enums;

/**
 * All error codes returned by the RS WaybillService API.
 *
 * Each case value is the integer code returned in the RS API response.
 * Use WaybillErrorCode::tryFrom($id) to safely convert an API error ID.
 *
 * Error types:
 *   1  — Waybill-level validation
 *   2  — Product / goods-line validation
 *   3  — Invoice / VAT errors
 *   4  — Tax declaration period errors
 *   5  — Vehicle registration errors
 *   10 — Access restriction errors
 */
enum WaybillErrorCode: int
{
    // -------------------------------------------------------------------------
    // General
    // -------------------------------------------------------------------------
    case UNKNOWN_ERROR                          = -1;
    case GENERAL_ERROR                          = -2;
    case RESTRICTED_BY_INVESTIGATION_SERVICE    = -21;
    case RESTRICTED_BY_REVENUE_SERVICE          = -22;
    case ACTION_NOT_PERMITTED                   = -23;

    // -------------------------------------------------------------------------
    // Authentication / request structure
    // -------------------------------------------------------------------------
    case INVALID_SERVICE_USER_OR_PASSWORD        = -100;
    case SELLER_UN_ID_MISMATCH                   = -101;
    case XML_PARSE_ERROR_OR_MISSING_SELLER_UN_ID = -102;
    case INVALID_WAYBILL_ID                      = -103;
    case DISQUALIFIED_VAT_PAYER_STATUS           = -229;

    // -------------------------------------------------------------------------
    // Access / restriction
    // -------------------------------------------------------------------------
    case ISSUANCE_RIGHT_RESTRICTED               = -500;
    case ADVANCE_INVOICE_ISSUANCE_RESTRICTED     = -1100;

    // -------------------------------------------------------------------------
    // Vehicle registration (type 5)
    // -------------------------------------------------------------------------
    case VEHICLE_ALREADY_REGISTERED              = -501;
    case NO_RIGHT_TO_CHANGE_VEHICLE_OWNER        = -502;
    case INVALID_CHASSIS_NUMBER                  = -503;
    case INVALID_NEW_OWNER_CODE                  = -504;
    case NO_RIGHT_TO_SET_VEHICLE_RED             = -505;
    case NO_RIGHT_TO_SET_VEHICLE_GREEN           = -506;

    // -------------------------------------------------------------------------
    // Waybill validation — type 1
    // -------------------------------------------------------------------------
    case INVALID_WAYBILL_TYPE                    = -1001;
    case INVALID_TRANSPORTATION_TYPE             = -1002;
    case BUYER_NAME_REQUIRED_FOR_FOREIGN         = -1003;
    case BUYER_REQUIRED                          = -1004;
    case BUYER_NOT_FOUND                         = -1005;
    case BUYER_LIQUIDATED_OR_CODE_CANCELLED      = -1006;
    case START_ADDRESS_TOO_LONG                  = -1007;
    case DRIVER_ID_TOO_LONG                      = -1008;
    case START_ADDRESS_REQUIRED                  = -1009;
    case END_ADDRESS_TOO_LONG                    = -1010;
    case END_ADDRESS_REQUIRED                    = -1011;
    case DRIVER_REQUIRED                         = -1012;
    case DRIVER_NAME_REQUIRED_FOR_FOREIGN        = -1013;
    case INVALID_DRIVER_ID                       = -1014;
    case RECEPTION_INFO_TOO_LONG                 = -1015;
    case RECEIVER_INFO_TOO_LONG                  = -1016;
    case DELIVERY_DATE_EXCEEDS_CURRENT           = -1017;
    case DELIVERY_DATE_BEFORE_START_DATE         = -1018;
    case INVALID_STATUS                          = -1019;
    case CANNOT_DELETE_UNSAVED                   = -1020;
    case CANNOT_CANCEL_UNSAVED                   = -1021;
    case SELLER_LIQUIDATED                       = -1022;
    case PARENT_REQUIRED_FOR_SUB_WAYBILL         = -1023;
    case PARENT_NOT_FOUND_OR_NOT_ACTIVE          = -1024;
    case SUB_WAYBILL_ONLY_FOR_DISTRIBUTION       = -1025;
    case INVALID_VEHICLE_NUMBER                  = -1026;
    case CANNOT_EDIT_CLOSED                      = -1027;
    case CANNOT_EDIT_OR_DELETE_DELETED           = -1028;
    case CANNOT_EDIT_OR_DELETE_CANCELLED         = -1029;
    case CANNOT_CANCEL_PARENT_WITH_SUB_WAYBILLS  = -1030;
    case CANNOT_DELETE_SENT                      = -1031;
    case CANNOT_CONVERT_SUB_TO_MAIN              = -1032;
    case CANNOT_CONVERT_ISSUED_TO_SUB            = -1033;
    case ACTIVATION_DATE_BEFORE_CREATION         = -1034;
    case INTERNAL_TRANSPORT_BUYER_CODE_RULE      = -1035;
    case NO_TRANSPORT_START_END_MUST_MATCH       = -1036;
    case OTHER_TRANSPORT_TYPE_REQUIRES_TRANS_TXT = -1037;
    case DEFERRED_DATE_EXCEEDS_3_DAYS            = -1038;
    case BUYER_MUST_DIFFER_FROM_SELLER           = -1039;
    case VEHICLE_NUMBER_REQUIRED                 = -1040;
    case INVALID_BUYER_SERVICE_USER_ID           = -1041;
    case CANNOT_EDIT_INVOICE_LINKED_WAYBILL      = -1042;
    case AMOUNT_EXCEEDS_BILLION                  = -1043;
    case CANNOT_ACTIVATE_EMPTY_WAYBILL           = -1045;
    case CANNOT_CHANGE_TYPE_ON_ACTIVE            = -1046;
    case SELLER_BUYER_SAME_ONLY_FOR_INTERNAL     = -1047;
    case INVALID_TRANSPORTER_ID                  = -1048;
    case TRANSPORTER_ID_ONLY_FOR_SENT_STATUS     = -1049;
    case TRANSPORTER_ID_REQUIRED                 = -1050;
    case CANNOT_CHANGE_DRIVER_ON_SENT_TO_TRANSPORTER = -1051;
    case ONLY_TRANSPORTER_CAN_CLOSE              = -1052;
    case DRIVER_FILLED_BY_TRANSPORTER            = -1053;
    case NOT_THE_TRANSPORTER_OF_THIS_WAYBILL     = -1054;
    case TIMBER_DOCUMENT_REQUIRED                = -1055;
    case TIMBER_DOCUMENT_NUMBER_REQUIRED         = -1056;
    case TIMBER_DOCUMENT_DATE_REQUIRED           = -1057;
    case CATEGORY_CHANGE_ONLY_ON_SAVED           = -1058;
    case CANNOT_ADD_SUB_TO_CLOSED_WAYBILL        = -1059;
    case INVALID_WAYBILL_CATEGORY                = -1060;
    case UNREAD_MANDATORY_NOTIFICATION           = -1061;
    case TRANSPORTER_ONLY_FOR_TRANSPORT_TYPES    = -1062;
    case CORRECTION_BLOCKED_BY_CUSTOMS           = -1063;
    case CREATION_DATE_RANGE_REQUIRED_MAX_72H    = -1064;
    case INVALID_FOREIGN_DRIVER_ID               = -1065;
    case INVALID_FOREIGN_BUYER_ID                = -1066;
    case TIMBER_DISTRIBUTION_NOT_ALLOWED         = -1067;
    case SUB_WAYBILL_CREATION_NOT_ALLOWED        = -1068;
    case TIMBER_PROTOCOL_CHANGED_AUG_2016        = -1069;
    case CANNOT_ATTACH_YELLOWED_INVOICE_TO_DECLARATION = -1070;
    case ISSUANCE_RESTRICTED_FOR_THIS_VEHICLE    = -1071;
    case LAST_CHANGE_DATE_RANGE_REQUIRED_MAX_3D  = -1072;
    case LAST_CHANGE_DATE_MUST_BE_IN_CREATION_RANGE = -1073;
    case RANGE_START_DATE_BEFORE_END_DATE        = -1074;
    case SERVICE_ONLY_ORDINARY_CATEGORY_EDIT     = -1075;
    case SERVICE_ONLY_ORDINARY_CATEGORY_CREATE   = -1076;
    case NOTIF_NBR_NOT_ALLOWED_FROM_SERVICE      = -1077;

    // -------------------------------------------------------------------------
    // Product / goods-line validation — type 2
    // -------------------------------------------------------------------------
    case PRODUCT_NAME_TOO_LONG                   = -2001;
    case INVALID_VAT_TYPE                        = -2002;
    case INVALID_UNIT_ID                         = -2003;
    case UNIT_TXT_REQUIRED_FOR_UNIT_99           = -2004;
    case QUANTITY_MUST_BE_POSITIVE               = -2005;
    case INVALID_GOODS_STATUS                    = -2006;
    case PRICE_REQUIRED                          = -2007;
    case INVALID_EXCISE_ID                       = -2008;
    case GOODS_NOT_FOUND_IN_PARENT_WAYBILL       = -2009;
    case EXCISE_CODE_NOT_FOR_THIS_PERIOD         = -2010;
    case DOC_N_REQUIRED                          = -2011;
    case DOC_DATE_REQUIRED                       = -2012;
    case DOC_DESC_REQUIRED                       = -2013;
    case TIMBER_STAMP_NUMBER_REQUIRED            = -2014;
    case INVALID_TIMBER_TYPE_ID                  = -2015;
    case STAMP_NUMBER_MUST_BE_10_DIGITS          = -2016;
    case BARCODE_NAME_COMBINATION_EXISTS         = -2018;
    case INVALID_MEDICATION_CODE                 = -2020;
    case QUANTITY_EXCEEDS_REMAINING_RESOURCE     = -4004;

    // -------------------------------------------------------------------------
    // Invoice / VAT — type 3
    // -------------------------------------------------------------------------
    case WAYBILL_NOT_FOUND                       = -3001;
    case SELLER_NOT_REGISTERED_IN_DECLARATION    = -3002;
    case WAYBILL_NOT_ACTIVATED                   = -3003;
    case SELLER_NOT_VAT_PAYER                    = -3004;
    case BUYER_CANCELLED_OR_NOT_VAT_PAYER        = -3005;
    case INVOICE_AND_WAYBILL_DIFFERENT_PAYERS    = -3006;
    case ERROR_IN_INVOICE_GOODS_LIST             = -3007;
    case ERROR_SAVING_INVOICE                    = -3008;
    case ERROR_IN_INVOICE_WAYBILL_LIST           = -3009;
    case INVOICE_SAVE_FAILED                     = -3010;
    case INVOICE_CORRECTION_FAILED               = -3011;
    case INVOICE_PRODUCT_SAVE_FAILED             = -3012;
    case INVOICE_WAYBILL_LINK_FAILED             = -3013;
    case INVOICE_STATUS_CHANGE_FAILED            = -3014;
    case INVOICE_CONFIRMATION_FAILED             = -3015;
    case INVOICE_CREATION_FAILED_WAYBILL_ISSUED_OR_CANCELLED = -3016;
    case PAYER_NOT_REGISTERED_IN_EDECLARATION    = -3017;
    case USER_NOT_VAT_PAYER                      = -3018;
    case DIPLOMAT_TAX_TYPE_MUST_BE_ZERO          = -3019;
    case OPERATION_DATE_EXCEEDS_CURRENT          = -3020;
    case USER_CANCELLED_NO_SEND_RIGHT            = -3021;
    case FUNCTION_TEMPORARILY_DISABLED           = -3022;
    case NOT_VAT_PAYER_IN_THIS_PERIOD            = -3023;
    case SELLER_ORGANISATION_LIQUIDATED          = -3024;
    case BUYER_ORGANISATION_LIQUIDATED           = -3025;
    case GOODS_LIST_CANNOT_BE_EMPTY              = -3026;
    case INVOICE_ATTACHMENT_TO_DECLARATION_BLOCKED = -4005;

    // -------------------------------------------------------------------------
    // Tax declaration period — type 4
    // -------------------------------------------------------------------------
    case DECLARATION_NOT_APPLICABLE_FOR_PERIOD   = -20012;
    case DECLARATION_PERIOD_STATUTE_OF_LIMITATIONS = -20021;

    // -------------------------------------------------------------------------
    // Miscellaneous server-side
    // -------------------------------------------------------------------------
    case ERROR_IN_GOODS_LIST                     = -4001;
    case TEST_CODES_ONLY_IN_TEST_ENVIRONMENT     = -4002;
    case ERROR_IN_TIMBER_STAMP_NUMBERS           = -4003;

    // -------------------------------------------------------------------------
    // Methods
    // -------------------------------------------------------------------------

    /**
     * Returns the Georgian error message as published by the RS API.
     */
    public function message(): string
    {
        return match ($this) {
            self::UNKNOWN_ERROR                          => 'გაურკვეველი შეცდომა',
            self::GENERAL_ERROR                          => 'ზოგადი შეცდომა (არამთელ რიცხვებს გამყოფად წერტილი უნდა ჰქონდეთ)',
            self::RESTRICTED_BY_INVESTIGATION_SERVICE    => 'სერვისით სარგებლობა შეზღუდულია ფინანსთა სამინისტროს საგამოძიებო სამსახურის მოთხოვნით',
            self::RESTRICTED_BY_REVENUE_SERVICE          => 'სერვისით სარგებლობა შეზღუდულია შემოსავლების სამსახურის მოთხოვნით',
            self::ACTION_NOT_PERMITTED                   => 'აღნიშნული ქმედების განხორციელების უფლება არ გაქვთ',
            self::INVALID_SERVICE_USER_OR_PASSWORD       => 'სერვისის მომხმარებელი ან პაროლი არასწორია',
            self::SELLER_UN_ID_MISMATCH                  => 'გამომწერის un_id განსხვავდება XML-ში მითითებული seler_un_id-ისგან',
            self::XML_PARSE_ERROR_OR_MISSING_SELLER_UN_ID => 'შეცდომა XML-ის პარსირებისას ან SELER_UN_ID ტეგი არ გაქვთ',
            self::INVALID_WAYBILL_ID                     => 'ზედნადების id არასწორია',
            self::DISQUALIFIED_VAT_PAYER_STATUS          => 'მინიჭებული გაქვთ არაკვალიფიციური დღგ-ს გადამხდელის სტატუსი',
            self::ISSUANCE_RIGHT_RESTRICTED              => 'შეზღუდული გაქვთ გამოწერის უფლება',
            self::ADVANCE_INVOICE_ISSUANCE_RESTRICTED    => 'შეზღუდული გაქვთ ავანსის ანგარიშ-ფაქტურის/ზედნადების გამოწერის უფლება',
            self::VEHICLE_ALREADY_REGISTERED             => 'ეს ავტომანქანა უკვე გაფორმებულია',
            self::NO_RIGHT_TO_CHANGE_VEHICLE_OWNER       => 'ამ ავტომანქანაზე მფლობელის შეცვლის უფლება არ გაქვთ',
            self::INVALID_CHASSIS_NUMBER                 => 'არასწორი შასის ნომერი',
            self::INVALID_NEW_OWNER_CODE                 => 'ახალი მფლობელის არასწორი კოდი',
            self::NO_RIGHT_TO_SET_VEHICLE_RED            => 'ამ ავტომანქანის წითელში გადაყვანის უფლება არ გაქვთ',
            self::NO_RIGHT_TO_SET_VEHICLE_GREEN          => 'ამ ავტომანქანის მწვანეში გადაყვანის უფლება არ გაქვთ',
            self::INVALID_WAYBILL_TYPE                   => 'ზედნადების ტიპი არასწორია',
            self::INVALID_TRANSPORTATION_TYPE            => 'ტრანსპორტირების ტიპი არასწორია',
            self::BUYER_NAME_REQUIRED_FOR_FOREIGN        => 'მყიდველის სახელი აუცილებელია, როცა მყიდველი უცხო ქვეყნის მოქალაქეა',
            self::BUYER_REQUIRED                         => 'მყიდველი აუცილებელია ყოველთვის გარდა შიდა გადაზიდვისა',
            self::BUYER_NOT_FOUND                        => 'მყიდველი არ მოიძებნა',
            self::BUYER_LIQUIDATED_OR_CODE_CANCELLED     => 'მყიდველი ლიკვიდირებულია ან კოდი გაუქმებულია',
            self::START_ADDRESS_TOO_LONG                 => 'ტრანსპორტირების დაწყების ადგილი (მისამართი) გრძელია',
            self::DRIVER_ID_TOO_LONG                     => 'მძღოლის პირადი ნომერი გრძელია',
            self::START_ADDRESS_REQUIRED                 => 'ტრანსპორტირების დაწყების ადგილი (მისამართი) აუცილებელია',
            self::END_ADDRESS_TOO_LONG                   => 'ტრანსპორტირების დასრულების ადგილი (მისამართი) გრძელია',
            self::END_ADDRESS_REQUIRED                   => 'ტრანსპორტირების დასრულების ადგილი (მისამართი) აუცილებელია',
            self::DRIVER_REQUIRED                        => 'მძღოლის მითითება აუცილებელია ტრანსპორტირების ყველა ზედნადებზე',
            self::DRIVER_NAME_REQUIRED_FOR_FOREIGN       => 'მძღოლის სახელი აუცილებელია, როდესაც მძღოლი უცხო ქვეყნის მოქალაქეა',
            self::INVALID_DRIVER_ID                      => 'მძღოლის პირადი ნომერი არასწორია',
            self::RECEPTION_INFO_TOO_LONG                => 'reception_info გრძელია',
            self::RECEIVER_INFO_TOO_LONG                 => 'receiver_info გრძელია',
            self::DELIVERY_DATE_EXCEEDS_CURRENT          => 'მიწოდების თარიღი მეტია მიმდინარე თარიღზე',
            self::DELIVERY_DATE_BEFORE_START_DATE        => 'მიწოდების თარიღი ნაკლებია ტრანსპორტირების დაწყების თარიღზე',
            self::INVALID_STATUS                         => 'სტატუსი არასწორია',
            self::CANNOT_DELETE_UNSAVED                  => 'შეუნახავს ვერ წაშლით',
            self::CANNOT_CANCEL_UNSAVED                  => 'შეუნახავს ვერ გააუქმებთ',
            self::SELLER_LIQUIDATED                      => 'გამყიდველი ლიკვიდირებულია',
            self::PARENT_REQUIRED_FOR_SUB_WAYBILL        => 'ქვე-ზედნადებისთვის მშობელი აუცილებელია',
            self::PARENT_NOT_FOUND_OR_NOT_ACTIVE         => 'მშობელი არ მოიძებნა ან მშობელი გააქტიურებული არ არის',
            self::SUB_WAYBILL_ONLY_FOR_DISTRIBUTION      => 'ქვე-ზედნადები მხოლოდ დისტრიბუციაზე იწერება',
            self::INVALID_VEHICLE_NUMBER                 => 'მანქანის/მოპედის/მოტოციკლის ნომერი არასწორია',
            self::CANNOT_EDIT_CLOSED                     => 'დასრულებულის რედაქტირებას ვერ შეძლებთ',
            self::CANNOT_EDIT_OR_DELETE_DELETED          => 'წაშლილ ზედნადებს ვერ დაარედაქტირებთ და ვერ წაშლით',
            self::CANNOT_EDIT_OR_DELETE_CANCELLED        => 'გაუქმებულ ზედნადებს ვერ დაარედაქტირებთ და ვერ წაშლით',
            self::CANNOT_CANCEL_PARENT_WITH_SUB_WAYBILLS => 'მშობელ ზედნადებს ვერ გააუქმებთ თუ ქვე-ზედნადები აქვს',
            self::CANNOT_DELETE_SENT                     => 'გადაგზავნილს ვერ წაშლით',
            self::CANNOT_CONVERT_SUB_TO_MAIN             => 'ქვე-ზედნადებს ძირითად ზედნადებად ვერ გადააკეთებთ',
            self::CANNOT_CONVERT_ISSUED_TO_SUB           => 'გამოწერილ ზედნადებს ქვე-ზედნადებად ვერ გადააკეთებთ',
            self::ACTIVATION_DATE_BEFORE_CREATION        => 'აქტივაციის თარიღი ნაკლებია შექმნის თარიღზე',
            self::INTERNAL_TRANSPORT_BUYER_CODE_RULE     => 'შიდა გადაზიდვისას მყიდველის კოდი ცარიელი ან გამყიდველის კოდი უნდა იყოს მითითებული',
            self::NO_TRANSPORT_START_END_MUST_MATCH      => '"ტრანსპორტირების გარეშე" შემთხვევაში დაწყებისა და დასრულების ადგილი უნდა ემთხვეოდეს',
            self::OTHER_TRANSPORT_TYPE_REQUIRES_TRANS_TXT => 'ტრანსპორტირების ტიპი "სხვა" — მიუთითეთ TRANS_TXT',
            self::DEFERRED_DATE_EXCEEDS_3_DAYS           => 'გადავადების (აქტივაციის) თარიღი არ უნდა აღემატებოდეს 3 დღეს',
            self::BUYER_MUST_DIFFER_FROM_SELLER          => 'მყიდველი უნდა განსხვავდებოდეს გამყიდველისგან (თუ შიდა გადაზიდვა არ არის)',
            self::VEHICLE_NUMBER_REQUIRED                => 'მანქანის/მოპედის/მოტოციკლის ნომერი აუცილებელია',
            self::INVALID_BUYER_SERVICE_USER_ID          => 'მყიდველის სერვისის მომხმარებლის ID არასწორია',
            self::CANNOT_EDIT_INVOICE_LINKED_WAYBILL     => 'ფაქტურაზე მიბმულ ზედნადებს ვერ დაარედაქტირებთ',
            self::AMOUNT_EXCEEDS_BILLION                 => 'თანხა აღემატება 1,000,000,000-ს',
            self::CANNOT_ACTIVATE_EMPTY_WAYBILL          => 'ცარიელ ზედნადებს ვერ გააქტიურებთ',
            self::CANNOT_CHANGE_TYPE_ON_ACTIVE           => 'აქტიურ ზედნადებზე ზედნადების ტიპს ვერ შეცვლით',
            self::SELLER_BUYER_SAME_ONLY_FOR_INTERNAL    => 'გამყიდველი და მყიდველი მხოლოდ შიდა გადაზიდვისას შეიძლება იყოს ერთი',
            self::INVALID_TRANSPORTER_ID                 => 'გადამზიდავის ს/ნ არასწორია',
            self::TRANSPORTER_ID_ONLY_FOR_SENT_STATUS    => 'გადამზიდავის ს/ნ მინიჭება/შეცვლა/წაშლა შეიძლება მხოლოდ "გადამზიდავთან გადაგზავნილი" სტატუსის ზედნადებზე',
            self::TRANSPORTER_ID_REQUIRED                => 'გადამზიდავის ს/ნ აუცილებელია',
            self::CANNOT_CHANGE_DRIVER_ON_SENT_TO_TRANSPORTER => '"გადამზიდავთან გადაგზავნილი" სტატუსის ზედნადებზე მძღოლს და ტრანსპორტირების ტიპს ვერ შეცვლით',
            self::ONLY_TRANSPORTER_CAN_CLOSE             => '"გადამზიდავთან გადაგზავნილი" სტატუსის ზედნადებს ვერ დაასრულებთ — ასრულებს გადამზიდავი',
            self::DRIVER_FILLED_BY_TRANSPORTER           => 'მძღოლის მონაცემებს და ტრანსპორტირების ტიპს ავსებს გადამზიდავი',
            self::NOT_THE_TRANSPORTER_OF_THIS_WAYBILL    => 'თქვენ არ ხართ ამ ზედნადების გადამზიდავი',
            self::TIMBER_DOCUMENT_REQUIRED               => 'ხე-ტყის დოკუმენტი აუცილებელია',
            self::TIMBER_DOCUMENT_NUMBER_REQUIRED        => 'ხე-ტყის დოკუმენტის ნომერი აუცილებელია',
            self::TIMBER_DOCUMENT_DATE_REQUIRED          => 'ხე-ტყის დოკუმენტის თარიღი აუცილებელია',
            self::CATEGORY_CHANGE_ONLY_ON_SAVED          => 'ზედნადების კატეგორიის შეცვლა შეიძლება მხოლოდ შენახულ ზედნადებზე',
            self::CANNOT_ADD_SUB_TO_CLOSED_WAYBILL       => 'დასრულებულ ზედნადებზე ქვე-ზედნადებს ვერ გამოწერთ',
            self::INVALID_WAYBILL_CATEGORY               => 'ზედნადების კატეგორია არასწორია',
            self::UNREAD_MANDATORY_NOTIFICATION          => 'გაქვთ წაუკითხავი, სავალდებულო შეტყობინება — გაეცანით შეტყობინებას',
            self::TRANSPORTER_ONLY_FOR_TRANSPORT_TYPES   => 'გადამზიდი შეიძლება გამოიყენოთ მხოლოდ ტრანსპორტირებით ან შიდა გადაზიდვის ტიპის ზედნადებებზე',
            self::CORRECTION_BLOCKED_BY_CUSTOMS          => 'კორექტირება შეუძლებელია — დადასტურებულია საბაჟოს მიერ',
            self::CREATION_DATE_RANGE_REQUIRED_MAX_72H   => 'შექმნის თარიღის დიაპაზონი აუცილებელია და არ უნდა აღემატებოდეს 72 საათს',
            self::INVALID_FOREIGN_DRIVER_ID              => 'უცხო ქვეყნის მოქალაქის პირადი ნომერი არასწორია (მძღოლი)',
            self::INVALID_FOREIGN_BUYER_ID               => 'უცხო ქვეყნის მოქალაქის პირადი ნომერი არასწორია (მყიდველი)',
            self::TIMBER_DISTRIBUTION_NOT_ALLOWED        => 'ხე-ტყის ზედნადების დისტრიბუციას ვერ გამოწერთ',
            self::SUB_WAYBILL_CREATION_NOT_ALLOWED       => 'მოცემულ პირზე ქვე-ზედნადების შექმნა შეუძლებელია — დაუკავშირდით ქოლცენტრს',
            self::TIMBER_PROTOCOL_CHANGED_AUG_2016       => 'ხე-ტყის ფაქტურების პროტოკოლი შეიცვალა 2016 წლის 1 აგვისტოდან',
            self::CANNOT_ATTACH_YELLOWED_INVOICE_TO_DECLARATION => 'გაყვითლებულ ანგარიშ-ფაქტურას ვერ მიაბამთ დეკლარაციაზე',
            self::ISSUANCE_RESTRICTED_FOR_THIS_VEHICLE   => 'ზედნადების გამოწერა შეზღუდულია აღნიშნულ სატრანსპორტო საშუალებაზე',
            self::LAST_CHANGE_DATE_RANGE_REQUIRED_MAX_3D => 'ბოლო ცვლილების თარიღის დიაპაზონი აუცილებელია და არ უნდა აღემატებოდეს 3 დღეს',
            self::LAST_CHANGE_DATE_MUST_BE_IN_CREATION_RANGE => 'ბოლო ცვლილების თარიღი შექმნის თარიღების შუალედში უნდა იყოს',
            self::RANGE_START_DATE_BEFORE_END_DATE       => 'დიაპაზონის საწყისი თარიღი ნაკლებია დასრულების თარიღზე',
            self::SERVICE_ONLY_ORDINARY_CATEGORY_EDIT    => 'სერვისიდან მხოლოდ ჩვეულებრივი კატეგორიის ზედნადებში ცვლილება დასაშვებია',
            self::SERVICE_ONLY_ORDINARY_CATEGORY_CREATE  => 'სერვისიდან მხოლოდ ჩვეულებრივი კატეგორიის ზედნადების შექმნაა დასაშვები',
            self::NOTIF_NBR_NOT_ALLOWED_FROM_SERVICE     => 'სერვისიდან NOTIF_NBR პარამეტრს ვერ გადასცემთ',
            self::PRODUCT_NAME_TOO_LONG                  => 'პროდუქტის დასახელება გრძელია',
            self::INVALID_VAT_TYPE                       => 'vat_type არასწორია',
            self::INVALID_UNIT_ID                        => 'unit_id არასწორია',
            self::UNIT_TXT_REQUIRED_FOR_UNIT_99          => 'unit_txt აუცილებელია, როცა unit_id = 99',
            self::QUANTITY_MUST_BE_POSITIVE              => 'რაოდენობა 0-ზე მეტი უნდა იყოს',
            self::INVALID_GOODS_STATUS                   => 'ქონების სტატუსი არასწორია',
            self::PRICE_REQUIRED                         => 'price აუცილებელია, გარდა შიდა გადაზიდვისა',
            self::INVALID_EXCISE_ID                      => 'აქციზის ID არასწორია',
            self::GOODS_NOT_FOUND_IN_PARENT_WAYBILL      => 'მშობელ ზედნადებში შესაბამისი საქონელი, ერთეული ან შტრიხკოდი არ არის',
            self::EXCISE_CODE_NOT_FOR_THIS_PERIOD        => 'საქონლის აქციზური კოდი მოცემულ პერიოდს არ ეკუთვნის',
            self::DOC_N_REQUIRED                         => 'DOC_N აუცილებელია',
            self::DOC_DATE_REQUIRED                      => 'DOC_DATE აუცილებელია',
            self::DOC_DESC_REQUIRED                      => 'DOC_DESC აუცილებელია',
            self::TIMBER_STAMP_NUMBER_REQUIRED           => 'ხე-ტყის ფაქტურაში ფირნიშის ნომერი აუცილებელია',
            self::INVALID_TIMBER_TYPE_ID                 => 'ხე-ტყის ტიპის ID არასწორია',
            self::STAMP_NUMBER_MUST_BE_10_DIGITS         => 'ფირნიშის ნომერი 10 ნიშნა უნდა იყოს',
            self::BARCODE_NAME_COMBINATION_EXISTS        => 'ასეთი შტრიხკოდისა და დასახელების კომბინაცია უკვე დამატებულია',
            self::INVALID_MEDICATION_CODE                => 'მედიკამენტის კოდი არასწორია',
            self::QUANTITY_EXCEEDS_REMAINING_RESOURCE    => 'პროდუქციის რაოდენობა აღემატება დარჩენილ რესურსს',
            self::WAYBILL_NOT_FOUND                      => 'ზედნადები არ მოიძებნა',
            self::SELLER_NOT_REGISTERED_IN_DECLARATION   => 'გამყიდველი არ არის დეკლარირებაში რეგისტრირებული',
            self::WAYBILL_NOT_ACTIVATED                  => 'ზედნადები გააქტიურებული არ არის',
            self::SELLER_NOT_VAT_PAYER                   => 'გამყიდველი არ არის დღგ-ს გადამხდელი',
            self::BUYER_CANCELLED_OR_NOT_VAT_PAYER       => 'მყიდველი გაუქმებულია ან არ არის დღგ-ს გადამხდელი',
            self::INVOICE_AND_WAYBILL_DIFFERENT_PAYERS   => 'ანგარიშ-ფაქტურა და ზედნადები სხვადასხვა გადამხდელზეა',
            self::ERROR_IN_INVOICE_GOODS_LIST            => 'ფაქტურაში საქონლის ჩამონათვალში შეცდომა',
            self::ERROR_SAVING_INVOICE                   => 'ფაქტურის შენახვისას შეცდომა',
            self::ERROR_IN_INVOICE_WAYBILL_LIST          => 'ფაქტურაში ზედნადებების ჩამონათვალში შეცდომა',
            self::INVOICE_SAVE_FAILED                    => 'ანგარიშ-ფაქტურის შენახვა ვერ მოხერხდა',
            self::INVOICE_CORRECTION_FAILED              => 'ანგარიშ-ფაქტურის კორექტირება ვერ მოხერხდა',
            self::INVOICE_PRODUCT_SAVE_FAILED            => 'ანგარიშ-ფაქტურის პროდუქციის შენახვა ვერ მოხერხდა',
            self::INVOICE_WAYBILL_LINK_FAILED            => 'ანგარიშ-ფაქტურის ზედნადებზე მიბმა ვერ განხორციელდა',
            self::INVOICE_STATUS_CHANGE_FAILED           => 'ანგარიშ-ფაქტურის სტატუსის შეცვლა ვერ მოხერხდა',
            self::INVOICE_CONFIRMATION_FAILED            => 'ანგარიშ-ფაქტურის დადასტურება ვერ მოხერხდა',
            self::INVOICE_CREATION_FAILED_WAYBILL_ISSUED_OR_CANCELLED => 'ანგარიშ-ფაქტურის შექმნა ვერ მოხერხდა (ზედნადები გაუქმებულია ან უკვე გამოწერილია)',
            self::PAYER_NOT_REGISTERED_IN_EDECLARATION   => 'გადამხდელი არ არის ელ-დეკლარირებაში რეგისტრირებული',
            self::USER_NOT_VAT_PAYER                     => 'მომხმარებელი არ არის დღგ-ს გადამხდელი',
            self::DIPLOMAT_TAX_TYPE_MUST_BE_ZERO         => 'დიპლომატის შემთხვევაში დაბეგვრის ტიპი ნულოვანი უნდა იყოს',
            self::OPERATION_DATE_EXCEEDS_CURRENT         => 'ოპერაციის თარიღი არ უნდა აღემატებოდეს მიმდინარე თარიღს',
            self::USER_CANCELLED_NO_SEND_RIGHT           => 'მომხმარებელი გაუქმებულია — გადაგზავნის უფლება არ გაქვთ',
            self::FUNCTION_TEMPORARILY_DISABLED          => 'ეს ფუნქცია დროებით გათიშულია',
            self::NOT_VAT_PAYER_IN_THIS_PERIOD           => 'ამ პერიოდში დღგ-ს გადამხდელად არ იყავით რეგისტრირებული',
            self::SELLER_ORGANISATION_LIQUIDATED         => 'თქვენი ორგანიზაცია ლიკვიდირებული/გაუქმებულია',
            self::BUYER_ORGANISATION_LIQUIDATED          => 'მყიდველის ორგანიზაცია ლიკვიდირებული/გაუქმებულია',
            self::GOODS_LIST_CANNOT_BE_EMPTY             => 'პროდუქცია ცარიელი ვერ იქნება',
            self::INVOICE_ATTACHMENT_TO_DECLARATION_BLOCKED => 'შემოწმებულ/დარიცხულ პერიოდზე ანგ-ფაქტურის გამოწერა შეზღუდულია',
            self::DECLARATION_NOT_APPLICABLE_FOR_PERIOD  => 'მოცემულ პერიოდში დეკლარირება არ გეკუთვნით',
            self::DECLARATION_PERIOD_STATUTE_OF_LIMITATIONS => 'ხანდაზმულობის ვადის გასვლის გამო ამ პერიოდის დეკლარაციის წარდგენა შეუძლებელია',
            self::ERROR_IN_GOODS_LIST                    => 'შეცდომა სასაქონლო მატერიალური ფასეულობების სიაში',
            self::TEST_CODES_ONLY_IN_TEST_ENVIRONMENT    => 'სატესტო კოდებიდან მხოლოდ სატესტო გარემოში გამოწერეთ',
            self::ERROR_IN_TIMBER_STAMP_NUMBERS          => 'შეცდომა ხე-ტყის ფირნიშის ნომრებში',
        };
    }

    /**
     * Returns the error type as defined by the RS API.
     * null means the RS API did not assign a type to this code.
     */
    public function type(): int|null
    {
        return match ($this) {
            self::RESTRICTED_BY_INVESTIGATION_SERVICE,
            self::RESTRICTED_BY_REVENUE_SERVICE,
            self::ACTION_NOT_PERMITTED                   => 10,

            self::VEHICLE_ALREADY_REGISTERED,
            self::NO_RIGHT_TO_CHANGE_VEHICLE_OWNER,
            self::INVALID_CHASSIS_NUMBER,
            self::INVALID_NEW_OWNER_CODE,
            self::NO_RIGHT_TO_SET_VEHICLE_RED,
            self::NO_RIGHT_TO_SET_VEHICLE_GREEN          => 5,

            self::PRODUCT_NAME_TOO_LONG,
            self::INVALID_VAT_TYPE,
            self::INVALID_UNIT_ID,
            self::UNIT_TXT_REQUIRED_FOR_UNIT_99,
            self::QUANTITY_MUST_BE_POSITIVE,
            self::INVALID_GOODS_STATUS,
            self::PRICE_REQUIRED,
            self::INVALID_EXCISE_ID,
            self::GOODS_NOT_FOUND_IN_PARENT_WAYBILL,
            self::EXCISE_CODE_NOT_FOR_THIS_PERIOD,
            self::DOC_N_REQUIRED,
            self::DOC_DATE_REQUIRED,
            self::DOC_DESC_REQUIRED,
            self::TIMBER_STAMP_NUMBER_REQUIRED,
            self::INVALID_TIMBER_TYPE_ID,
            self::STAMP_NUMBER_MUST_BE_10_DIGITS,
            self::BARCODE_NAME_COMBINATION_EXISTS,
            self::INVALID_MEDICATION_CODE,
            self::GENERAL_ERROR,
            self::QUANTITY_EXCEEDS_REMAINING_RESOURCE    => 2,

            self::WAYBILL_NOT_FOUND,
            self::SELLER_NOT_REGISTERED_IN_DECLARATION,
            self::WAYBILL_NOT_ACTIVATED,
            self::SELLER_NOT_VAT_PAYER,
            self::BUYER_CANCELLED_OR_NOT_VAT_PAYER,
            self::INVOICE_AND_WAYBILL_DIFFERENT_PAYERS,
            self::ERROR_IN_INVOICE_GOODS_LIST,
            self::ERROR_SAVING_INVOICE,
            self::ERROR_IN_INVOICE_WAYBILL_LIST,
            self::INVOICE_SAVE_FAILED,
            self::INVOICE_CORRECTION_FAILED,
            self::INVOICE_PRODUCT_SAVE_FAILED,
            self::INVOICE_WAYBILL_LINK_FAILED,
            self::INVOICE_STATUS_CHANGE_FAILED,
            self::INVOICE_CONFIRMATION_FAILED,
            self::INVOICE_CREATION_FAILED_WAYBILL_ISSUED_OR_CANCELLED,
            self::PAYER_NOT_REGISTERED_IN_EDECLARATION,
            self::USER_NOT_VAT_PAYER,
            self::DIPLOMAT_TAX_TYPE_MUST_BE_ZERO,
            self::OPERATION_DATE_EXCEEDS_CURRENT,
            self::USER_CANCELLED_NO_SEND_RIGHT,
            self::FUNCTION_TEMPORARILY_DISABLED,
            self::NOT_VAT_PAYER_IN_THIS_PERIOD,
            self::SELLER_ORGANISATION_LIQUIDATED,
            self::BUYER_ORGANISATION_LIQUIDATED,
            self::GOODS_LIST_CANNOT_BE_EMPTY,
            self::DISQUALIFIED_VAT_PAYER_STATUS,
            self::CANNOT_ATTACH_YELLOWED_INVOICE_TO_DECLARATION,
            self::INVOICE_ATTACHMENT_TO_DECLARATION_BLOCKED => 3,

            self::DECLARATION_NOT_APPLICABLE_FOR_PERIOD,
            self::DECLARATION_PERIOD_STATUTE_OF_LIMITATIONS => 4,

            self::AMOUNT_EXCEEDS_BILLION,
            self::ISSUANCE_RIGHT_RESTRICTED              => null,

            default                                      => 1,
        };
    }

    public function isWaybillError(): bool { return $this->type() === 1; }
    public function isProductError(): bool { return $this->type() === 2; }
    public function isInvoiceError(): bool { return $this->type() === 3; }
    public function isRestriction(): bool  { return $this->type() === 10; }
}
