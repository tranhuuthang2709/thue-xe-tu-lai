const host = "https://provinces.open-api.vn/api/";

// Gọi API để lấy danh sách tỉnh
var callAPI = (api, selectId) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data, selectId);
        });
}
callAPI('https://provinces.open-api.vn/api/?depth=1', 'pickup_province');
callAPI('https://provinces.open-api.vn/api/?depth=1', 'return_province');

// Gọi API để lấy danh sách quận/huyện
var callApiDistrict = (api, selectId) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data.districts, selectId);
        })
        .catch((error) => {
            console.error("Error fetching districts: ", error);
        });
}

// Gọi API để lấy danh sách phường/xã
var callApiWard = (api, selectId) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data.wards, selectId);
        })
        .catch((error) => {
            console.error("Error fetching wards: ", error);
        });
}

// Hàm để render dữ liệu vào các dropdown
var renderData = (array, selectId) => {
    let row = '<option value="">Chọn</option>';
    array.forEach(element => {
        row += `<option value="${element.code}" data-name="${element.name}">${element.name}</option>`;
    });
    document.querySelector("#" + selectId).innerHTML = row;
}

// Lưu tên tỉnh, quận, phường khi người dùng thay đổi
var returnProvinceName = "";
var returnDistrictName = "";
var returnWardName = "";
var pickupProvinceName = "";
var pickupDistrictName = "";
var pickupWardName = "";

// Khi thay đổi tỉnh của địa điểm nhận xe, gọi API lấy quận
$("#pickup_province").change(() => {
    pickupProvinceName = $("#pickup_province option:selected").data("name");
    callApiDistrict(host + "p/" + $("#pickup_province").val() + "?depth=2", 'pickup_district');
    printResult();
});

// Khi thay đổi quận của địa điểm nhận xe, gọi API lấy phường
$("#pickup_district").change(() => {
    pickupDistrictName = $("#pickup_district option:selected").data("name");
    callApiWard(host + "d/" + $("#pickup_district").val() + "?depth=2", 'pickup_ward');
    printResult();
});

// Khi thay đổi phường của địa điểm nhận xe, hiển thị kết quả
$("#pickup_ward").change(() => {
    pickupWardName = $("#pickup_ward option:selected").data("name");
    printResult();
});

// Khi thay đổi tỉnh của địa điểm trả xe, gọi API lấy quận
$("#return_province").change(() => {
    returnProvinceName = $("#return_province option:selected").data("name");
    callApiDistrict(host + "p/" + $("#return_province").val() + "?depth=2", 'return_district');
    printResult();
});

// Khi thay đổi quận của địa điểm trả xe, gọi API lấy phường
$("#return_district").change(() => {
    returnDistrictName = $("#return_district option:selected").data("name");
    callApiWard(host + "d/" + $("#return_district").val() + "?depth=2", 'return_ward');
    printResult();
});

// Khi thay đổi phường của địa điểm trả xe, hiển thị kết quả
$("#return_ward").change(() => {
    returnWardName = $("#return_ward option:selected").data("name");
    printResult();
});

// Hàm hiển thị kết quả khi người dùng chọn tỉnh, quận, phường
var printResult = () => {
    // Kiểm tra nếu tất cả các dropdown đã có giá trị
    if ($("#pickup_province").val() && $("#pickup_district").val() && $("#pickup_ward").val()) {
        let pickupProvince = pickupProvinceName;
        let pickupDistrict = pickupDistrictName;
        let pickupWard = pickupWardName;

        // Cập nhật giá trị vào các ô input ẩn để gửi lên form (Dành cho việc gửi tên)
        $("input[name='pickup_province']").val(pickupProvince);
        $("input[name='pickup_district']").val(pickupDistrict);
        $("input[name='pickup_ward']").val(pickupWard);
    }

    if ($("#return_province").val() && $("#return_district").val() && $("#return_ward").val()) {
        let returnProvince = returnProvinceName;
        let returnDistrict = returnDistrictName;
        let returnWard = returnWardName;

        // Cập nhật giá trị vào các ô input ẩn để gửi lên form (Dành cho việc gửi tên)
        $("input[name='return_province']").val(returnProvince);
        $("input[name='return_district']").val(returnDistrict);
        $("input[name='return_ward']").val(returnWard);
    }
}
