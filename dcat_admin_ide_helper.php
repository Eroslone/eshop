<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection city_name
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection default
     * @property Grid\Column|Collection district_name
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection province_name
     * @property Grid\Column|Collection recipients
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection level
     * @property Grid\Column|Collection pid
     * @property Grid\Column|Collection zip_code
     * @property Grid\Column|Collection attr_name
     * @property Grid\Column|Collection picture
     * @property Grid\Column|Collection collective_id
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection discount
     * @property Grid\Column|Collection goods_id
     * @property Grid\Column|Collection need
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection store_id
     * @property Grid\Column|Collection order_son_id
     * @property Grid\Column|Collection size_id
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection client_id
     * @property Grid\Column|Collection expires_at
     * @property Grid\Column|Collection revoked
     * @property Grid\Column|Collection scopes
     * @property Grid\Column|Collection password_client
     * @property Grid\Column|Collection personal_access_client
     * @property Grid\Column|Collection provider
     * @property Grid\Column|Collection redirect
     * @property Grid\Column|Collection secret
     * @property Grid\Column|Collection access_token_id
     * @property Grid\Column|Collection categories_id
     * @property Grid\Column|Collection order_id
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection product_id
     * @property Grid\Column|Collection quantity
     * @property Grid\Column|Collection state
     * @property Grid\Column|Collection address_id
     * @property Grid\Column|Collection express_company
     * @property Grid\Column|Collection express_no
     * @property Grid\Column|Collection no
     * @property Grid\Column|Collection over_time
     * @property Grid\Column|Collection paid_at
     * @property Grid\Column|Collection pay_status
     * @property Grid\Column|Collection payment_method
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection sign_time
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection delete
     * @property Grid\Column|Collection difference
     * @property Grid\Column|Collection stock
     * @property Grid\Column|Collection attr
     * @property Grid\Column|Collection describe
     * @property Grid\Column|Collection original_price
     * @property Grid\Column|Collection pictures
     * @property Grid\Column|Collection product_name
     * @property Grid\Column|Collection sales_volume
     * @property Grid\Column|Collection flow_id
     * @property Grid\Column|Collection freight_state
     * @property Grid\Column|Collection refund_describe
     * @property Grid\Column|Collection refund_image
     * @property Grid\Column|Collection refund_no
     * @property Grid\Column|Collection refund_reason
     * @property Grid\Column|Collection refuse_reason
     * @property Grid\Column|Collection return_way
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection end_at
     * @property Grid\Column|Collection start_at
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection ip_area
     * @property Grid\Column|Collection login_at
     * @property Grid\Column|Collection attributes_id
     * @property Grid\Column|Collection spec_name
     * @property Grid\Column|Collection city_id
     * @property Grid\Column|Collection district_id
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection last_login_at
     * @property Grid\Column|Collection last_login_ip
     * @property Grid\Column|Collection mobile
     * @property Grid\Column|Collection nickname
     * @property Grid\Column|Collection province_id
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection city_name(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection default(string $label = null)
     * @method Grid\Column|Collection district_name(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection province_name(string $label = null)
     * @method Grid\Column|Collection recipients(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection level(string $label = null)
     * @method Grid\Column|Collection pid(string $label = null)
     * @method Grid\Column|Collection zip_code(string $label = null)
     * @method Grid\Column|Collection attr_name(string $label = null)
     * @method Grid\Column|Collection picture(string $label = null)
     * @method Grid\Column|Collection collective_id(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection discount(string $label = null)
     * @method Grid\Column|Collection goods_id(string $label = null)
     * @method Grid\Column|Collection need(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection store_id(string $label = null)
     * @method Grid\Column|Collection order_son_id(string $label = null)
     * @method Grid\Column|Collection size_id(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection client_id(string $label = null)
     * @method Grid\Column|Collection expires_at(string $label = null)
     * @method Grid\Column|Collection revoked(string $label = null)
     * @method Grid\Column|Collection scopes(string $label = null)
     * @method Grid\Column|Collection password_client(string $label = null)
     * @method Grid\Column|Collection personal_access_client(string $label = null)
     * @method Grid\Column|Collection provider(string $label = null)
     * @method Grid\Column|Collection redirect(string $label = null)
     * @method Grid\Column|Collection secret(string $label = null)
     * @method Grid\Column|Collection access_token_id(string $label = null)
     * @method Grid\Column|Collection categories_id(string $label = null)
     * @method Grid\Column|Collection order_id(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection product_id(string $label = null)
     * @method Grid\Column|Collection quantity(string $label = null)
     * @method Grid\Column|Collection state(string $label = null)
     * @method Grid\Column|Collection address_id(string $label = null)
     * @method Grid\Column|Collection express_company(string $label = null)
     * @method Grid\Column|Collection express_no(string $label = null)
     * @method Grid\Column|Collection no(string $label = null)
     * @method Grid\Column|Collection over_time(string $label = null)
     * @method Grid\Column|Collection paid_at(string $label = null)
     * @method Grid\Column|Collection pay_status(string $label = null)
     * @method Grid\Column|Collection payment_method(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection sign_time(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection delete(string $label = null)
     * @method Grid\Column|Collection difference(string $label = null)
     * @method Grid\Column|Collection stock(string $label = null)
     * @method Grid\Column|Collection attr(string $label = null)
     * @method Grid\Column|Collection describe(string $label = null)
     * @method Grid\Column|Collection original_price(string $label = null)
     * @method Grid\Column|Collection pictures(string $label = null)
     * @method Grid\Column|Collection product_name(string $label = null)
     * @method Grid\Column|Collection sales_volume(string $label = null)
     * @method Grid\Column|Collection flow_id(string $label = null)
     * @method Grid\Column|Collection freight_state(string $label = null)
     * @method Grid\Column|Collection refund_describe(string $label = null)
     * @method Grid\Column|Collection refund_image(string $label = null)
     * @method Grid\Column|Collection refund_no(string $label = null)
     * @method Grid\Column|Collection refund_reason(string $label = null)
     * @method Grid\Column|Collection refuse_reason(string $label = null)
     * @method Grid\Column|Collection return_way(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection end_at(string $label = null)
     * @method Grid\Column|Collection start_at(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection ip_area(string $label = null)
     * @method Grid\Column|Collection login_at(string $label = null)
     * @method Grid\Column|Collection attributes_id(string $label = null)
     * @method Grid\Column|Collection spec_name(string $label = null)
     * @method Grid\Column|Collection city_id(string $label = null)
     * @method Grid\Column|Collection district_id(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection last_login_at(string $label = null)
     * @method Grid\Column|Collection last_login_ip(string $label = null)
     * @method Grid\Column|Collection mobile(string $label = null)
     * @method Grid\Column|Collection nickname(string $label = null)
     * @method Grid\Column|Collection province_id(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection address
     * @property Show\Field|Collection city_name
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection default
     * @property Show\Field|Collection district_name
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection province_name
     * @property Show\Field|Collection recipients
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection order
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection username
     * @property Show\Field|Collection level
     * @property Show\Field|Collection pid
     * @property Show\Field|Collection zip_code
     * @property Show\Field|Collection attr_name
     * @property Show\Field|Collection picture
     * @property Show\Field|Collection collective_id
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection discount
     * @property Show\Field|Collection goods_id
     * @property Show\Field|Collection need
     * @property Show\Field|Collection status
     * @property Show\Field|Collection store_id
     * @property Show\Field|Collection order_son_id
     * @property Show\Field|Collection size_id
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection client_id
     * @property Show\Field|Collection expires_at
     * @property Show\Field|Collection revoked
     * @property Show\Field|Collection scopes
     * @property Show\Field|Collection password_client
     * @property Show\Field|Collection personal_access_client
     * @property Show\Field|Collection provider
     * @property Show\Field|Collection redirect
     * @property Show\Field|Collection secret
     * @property Show\Field|Collection access_token_id
     * @property Show\Field|Collection categories_id
     * @property Show\Field|Collection order_id
     * @property Show\Field|Collection price
     * @property Show\Field|Collection product_id
     * @property Show\Field|Collection quantity
     * @property Show\Field|Collection state
     * @property Show\Field|Collection address_id
     * @property Show\Field|Collection express_company
     * @property Show\Field|Collection express_no
     * @property Show\Field|Collection no
     * @property Show\Field|Collection over_time
     * @property Show\Field|Collection paid_at
     * @property Show\Field|Collection pay_status
     * @property Show\Field|Collection payment_method
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection sign_time
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection delete
     * @property Show\Field|Collection difference
     * @property Show\Field|Collection stock
     * @property Show\Field|Collection attr
     * @property Show\Field|Collection describe
     * @property Show\Field|Collection original_price
     * @property Show\Field|Collection pictures
     * @property Show\Field|Collection product_name
     * @property Show\Field|Collection sales_volume
     * @property Show\Field|Collection flow_id
     * @property Show\Field|Collection freight_state
     * @property Show\Field|Collection refund_describe
     * @property Show\Field|Collection refund_image
     * @property Show\Field|Collection refund_no
     * @property Show\Field|Collection refund_reason
     * @property Show\Field|Collection refuse_reason
     * @property Show\Field|Collection return_way
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection end_at
     * @property Show\Field|Collection start_at
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection ip_area
     * @property Show\Field|Collection login_at
     * @property Show\Field|Collection attributes_id
     * @property Show\Field|Collection spec_name
     * @property Show\Field|Collection city_id
     * @property Show\Field|Collection district_id
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection last_login_at
     * @property Show\Field|Collection last_login_ip
     * @property Show\Field|Collection mobile
     * @property Show\Field|Collection nickname
     * @property Show\Field|Collection province_id
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection city_name(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection default(string $label = null)
     * @method Show\Field|Collection district_name(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection province_name(string $label = null)
     * @method Show\Field|Collection recipients(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection level(string $label = null)
     * @method Show\Field|Collection pid(string $label = null)
     * @method Show\Field|Collection zip_code(string $label = null)
     * @method Show\Field|Collection attr_name(string $label = null)
     * @method Show\Field|Collection picture(string $label = null)
     * @method Show\Field|Collection collective_id(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection discount(string $label = null)
     * @method Show\Field|Collection goods_id(string $label = null)
     * @method Show\Field|Collection need(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection store_id(string $label = null)
     * @method Show\Field|Collection order_son_id(string $label = null)
     * @method Show\Field|Collection size_id(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection client_id(string $label = null)
     * @method Show\Field|Collection expires_at(string $label = null)
     * @method Show\Field|Collection revoked(string $label = null)
     * @method Show\Field|Collection scopes(string $label = null)
     * @method Show\Field|Collection password_client(string $label = null)
     * @method Show\Field|Collection personal_access_client(string $label = null)
     * @method Show\Field|Collection provider(string $label = null)
     * @method Show\Field|Collection redirect(string $label = null)
     * @method Show\Field|Collection secret(string $label = null)
     * @method Show\Field|Collection access_token_id(string $label = null)
     * @method Show\Field|Collection categories_id(string $label = null)
     * @method Show\Field|Collection order_id(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection product_id(string $label = null)
     * @method Show\Field|Collection quantity(string $label = null)
     * @method Show\Field|Collection state(string $label = null)
     * @method Show\Field|Collection address_id(string $label = null)
     * @method Show\Field|Collection express_company(string $label = null)
     * @method Show\Field|Collection express_no(string $label = null)
     * @method Show\Field|Collection no(string $label = null)
     * @method Show\Field|Collection over_time(string $label = null)
     * @method Show\Field|Collection paid_at(string $label = null)
     * @method Show\Field|Collection pay_status(string $label = null)
     * @method Show\Field|Collection payment_method(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection sign_time(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection delete(string $label = null)
     * @method Show\Field|Collection difference(string $label = null)
     * @method Show\Field|Collection stock(string $label = null)
     * @method Show\Field|Collection attr(string $label = null)
     * @method Show\Field|Collection describe(string $label = null)
     * @method Show\Field|Collection original_price(string $label = null)
     * @method Show\Field|Collection pictures(string $label = null)
     * @method Show\Field|Collection product_name(string $label = null)
     * @method Show\Field|Collection sales_volume(string $label = null)
     * @method Show\Field|Collection flow_id(string $label = null)
     * @method Show\Field|Collection freight_state(string $label = null)
     * @method Show\Field|Collection refund_describe(string $label = null)
     * @method Show\Field|Collection refund_image(string $label = null)
     * @method Show\Field|Collection refund_no(string $label = null)
     * @method Show\Field|Collection refund_reason(string $label = null)
     * @method Show\Field|Collection refuse_reason(string $label = null)
     * @method Show\Field|Collection return_way(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection end_at(string $label = null)
     * @method Show\Field|Collection start_at(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection ip_area(string $label = null)
     * @method Show\Field|Collection login_at(string $label = null)
     * @method Show\Field|Collection attributes_id(string $label = null)
     * @method Show\Field|Collection spec_name(string $label = null)
     * @method Show\Field|Collection city_id(string $label = null)
     * @method Show\Field|Collection district_id(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection last_login_at(string $label = null)
     * @method Show\Field|Collection last_login_ip(string $label = null)
     * @method Show\Field|Collection mobile(string $label = null)
     * @method Show\Field|Collection nickname(string $label = null)
     * @method Show\Field|Collection province_id(string $label = null)
     */
    class Show {}

    /**
     * @method \Sparkinzy\Dcat\Distpicker\Distpicker distpicker(...$params)
     * @method \Weiaibaicai\Ueditor\Form\UEditor ueditor(...$params)
     * @method \App\Admin\Extensions\Form\SelectCreate selectCreate(...$params)
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     * @method \Sparkinzy\Dcat\Distpicker\DistpickerFilter distpicker(...$params)
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     * @method $this video(...$params)
     */
    class Field {}
}
