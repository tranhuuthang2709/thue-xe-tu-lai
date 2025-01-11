const host = "https://provinces.open-api.vn/api/";

// Gọi API để lấy danh sách tỉnh
var callAPI = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data, "province");
        });
}
callAPI('https://provinces.open-api.vn/api/?depth=1');

// Gọi API để lấy danh sách quận/huyện
var callApiDistrict = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data.districts, "district");
        });
}

// Gọi API để lấy danh sách phường/xã
var callApiWard = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data.wards, "ward");
        });
}

// Hàm để render dữ liệu vào các dropdown
var renderData = (array, select) => {
    let row = '<option  value="">Chọn</option>';
    array.forEach(element => {
        row += `<option value="${element.code}" data-name="${element.name}">${element.name}</option>`;
    });
    document.querySelector("#" + select).innerHTML = row;
}

// Lưu tên tỉnh, quận, phường khi người dùng thay đổi
var provinceName = "";
var districtName = "";
var wardName = "";

// Khi thay đổi tỉnh, gọi API lấy quận
$("#province").change(() => {
    provinceName = $("#province option:selected").data("name");
    callApiDistrict(host + "p/" + $("#province").val() + "?depth=2");
    printResult();
});

// Khi thay đổi quận, gọi API lấy phường
$("#district").change(() => {
    districtName = $("#district option:selected").data("name");
    callApiWard(host + "d/" + $("#district").val() + "?depth=2");
    printResult();
});

// Khi thay đổi phường, hiển thị kết quả
$("#ward").change(() => {
    wardName = $("#ward option:selected").data("name");
    printResult();
})

// Hàm hiển thị kết quả khi người dùng chọn tỉnh, quận, phường
var printResult = () => {
    if ($("#district").val() != "" && $("#province").val() != "" && $("#ward").val() != "") {
        let province = provinceName;
        let district = districtName;
        let ward = wardName;
        $("input[name='province']").val(province);
        $("input[name='district']").val(district);
        $("input[name='ward']").val(ward);
    }
}
