
FilePond.registerPlugin(
  FilePondPluginImagePreview,
  FilePondPluginImageCrop,
  FilePondPluginImageExifOrientation,
  FilePondPluginImageFilter,
  FilePondPluginImageResize,
  FilePondPluginFileValidateSize,
  FilePondPluginFileValidateType,
)

// Filepond: Basic
// FilePond.create(document.querySelector(".basic-filepond"), {
//   credits: null,
//   allowImagePreview: false,
//   allowMultiple: false,
//   allowFileEncode: false,
//   required: false,
//   storeAsFile: true,
// })
const filePondElements = document.querySelectorAll(".basic-filepond");
filePondElements.forEach(element => {
  FilePond.create(element, {
    credits: null,
    allowImagePreview: false,
    allowMultiple: false,
    allowFileEncode: false,
    required: false,
    storeAsFile: true,
  });
});

// Filepond: Multiple Files
FilePond.create(document.querySelector(".multiple-files-filepond"), {
  credits: null,
  allowImagePreview: false,
  allowMultiple: true,
  allowFileEncode: false,
  required: false,
  storeAsFile: true,
})

// Filepond: With Validation
// Validasi file laporan tugas akhir
FilePond.create(document.querySelector(".with-validation-filepond-laporan"), {
  credits: null,
  allowImagePreview: false,
  allowMultiple: true,
  allowFileEncode: false,
  required: true,
  acceptedFileTypes: ["application/pdf"],
  labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
  labelMaxFileSize: 'Maksimum ukuran file adalah 10 MB',
  labelFileTypeNotAllowed: 'Tipe file yang diunggah tidak valid',
  fileValidateTypeLabelExpectedTypes: 'File yang diunggah harus berupa PDF',
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
  storeAsFile: true,
}) 

// Validasi file bukti publikasi
FilePond.create(document.querySelector(".with-validation-filepond-publikasi"), {
  credits: null,
  allowImagePreview: false,
  allowMultiple: false,
  allowFileEncode: false,
  required: true,
  acceptedFileTypes: ["application/pdf"],
  labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
  labelMaxFileSize: 'Maksimum ukuran file adalah 1 MB',
  labelFileTypeNotAllowed: 'Tipe file yang diunggah tidak valid',
  fileValidateTypeLabelExpectedTypes: 'File yang diunggah harus berupa PDF',
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
  storeAsFile: true,
}) 

// Validasi file program / aplikasi /skripsi
FilePond.create(document.querySelector(".with-validation-filepond-program"), {
  credits: null,
  allowImagePreview: false,
  allowMultiple: false,
  allowFileEncode: false,
  required: true,
  acceptedFileTypes: [  "application/zip", 
    "application/x-zip-compressed", 
    "application/x-rar-compressed", 
    "application/rar"],
  labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
  labelMaxFileSize: 'Maksimum ukuran file adalah 100 MB',
  labelFileTypeNotAllowed: 'Tipe file yang diunggah tidak valid',
  fileValidateTypeLabelExpectedTypes: 'File yang diunggah harus berupa ZIP / RAR',
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
    
  storeAsFile: true,
}) 

const elements = document.querySelectorAll(".with-validation-filepond-admin1");
elements.forEach(element => {
  FilePond.create(element, {
    credits: null,
    allowImagePreview: false,
    allowMultiple: false,
    allowFileEncode: false,
    required: true,
    acceptedFileTypes: ["application/pdf"],
    labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
    labelMaxFileSize: 'Maksimum ukuran file adalah 10 MB',
    labelFileTypeNotAllowed: 'Tipe file yang diunggah tidak valid',
    fileValidateTypeLabelExpectedTypes: 'File yang diunggah harus berupa PDF',
    fileValidateTypeDetectType: (source, type) =>
      new Promise((resolve, reject) => {
        resolve(type);
      }),
    storeAsFile: true,
  });
});

const elements1 = document.querySelectorAll(".with-validation-filepond-admin2");
elements1.forEach(element => {
  FilePond.create(element, {
    credits: null,
    allowImagePreview: false,
    allowMultiple: false,
    allowFileEncode: false,
    required: true,
    acceptedFileTypes: ["application/pdf"],
    labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
    labelMaxFileSize: 'Maksimum ukuran file adalah 1 MB',
    labelFileTypeNotAllowed: 'Tipe file yang diunggah tidak valid',
    fileValidateTypeLabelExpectedTypes: 'File yang diunggah harus berupa PDF',
    fileValidateTypeDetectType: (source, type) =>
      new Promise((resolve, reject) => {
        resolve(type);
      }),
    storeAsFile: true,
  });
});

// const elements = document.querySelectorAll(".with-validation-filepond");
// elements.forEach(element => {
//   FilePond.create(element, {
//     credits: null,
//     allowImagePreview: false,
//     allowMultiple: true,
//     allowFileEncode: false,
//     required: true,
//     acceptedFileTypes: ["pdf"],
//     labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
//     labelMaxFileSize: 'Maksimum ukuran file adalah 1 MB',
//     fileValidateTypeDetectType: (source, type) =>
//       new Promise((resolve, reject) => {
//         resolve(type);
//       }),
//     storeAsFile: true,
//   });
// });

// Filepond: ImgBB with server property
FilePond.create(document.querySelector(".imgbb-filepond"), {
  credits: null,
  allowImagePreview: false,
  server: {
    process: (fieldName, file, metadata, load, error, progress, abort) => {
      // We ignore the metadata property and only send the file

      const formData = new FormData()
      formData.append(fieldName, file, file.name)

      const request = new XMLHttpRequest()
      // you can change it by your client api key
      request.open(
        "POST",
        "https://api.imgbb.com/1/upload?key=762894e2014f83c023b233b2f10395e2"
      )

      request.upload.onprogress = (e) => {
        progress(e.lengthComputable, e.loaded, e.total)
      }

      request.onload = function () {
        if (request.status >= 200 && request.status < 300) {
          load(request.responseText)
        } else {
          error("oh no")
        }
      }

      request.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) {
            let response = JSON.parse(this.responseText)

            Toastify({
              text: "Success uploading to imgbb! see console f12",
              duration: 3000,
              close: true,
              gravity: "bottom",
              position: "right",
              backgroundColor: "#4fbe87",
            }).showToast()
          } else {
            Toastify({
              text: "Failed uploading to imgbb! see console f12",
              duration: 3000,
              close: true,
              gravity: "bottom",
              position: "right",
              backgroundColor: "#ff0000",
            }).showToast()
          }
        }
      }

      request.send(formData)
    },
  },
  storeAsFile: true,
})

// Filepond: Image Preview
FilePond.create(document.querySelector(".image-preview-filepond"), {
  credits: null,
  allowImagePreview: true,
  allowImageFilter: false,
  allowImageExifOrientation: false,
  allowImageCrop: false,
  acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
  storeAsFile: true,
})

// Filepond: Image Crop
FilePond.create(document.querySelector(".image-crop-filepond"), {
  credits: null,
  allowImagePreview: true,
  allowImageFilter: false,
  allowImageExifOrientation: false,
  allowImageCrop: true,
  acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
  storeAsFile: true,
})

// Filepond: Image Exif Orientation
FilePond.create(document.querySelector(".image-exif-filepond"), {
  credits: null,
  allowImagePreview: true,
  allowImageFilter: false,
  allowImageExifOrientation: true,
  allowImageCrop: false,
  acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
  storeAsFile: true,
})

// Filepond: Image Filter
FilePond.create(document.querySelector(".image-filter-filepond"), {
  credits: null,
  allowImagePreview: true,
  allowImageFilter: true,
  allowImageExifOrientation: false,
  allowImageCrop: false,
  imageFilterColorMatrix: [
    0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114,
    0, 0, 0.0, 0.0, 0.0, 1, 0,
  ],
  acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
  storeAsFile: true,
})

// Filepond: Image Resize
FilePond.create(document.querySelector(".image-resize-filepond"), {
  credits: null,
  allowImagePreview: true,
  allowImageFilter: false,
  allowImageExifOrientation: false,
  allowImageCrop: false,
  allowImageResize: true,
  imageResizeTargetWidth: 200,
  imageResizeTargetHeight: 200,
  imageResizeMode: "cover",
  imageResizeUpscale: true,
  acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
  storeAsFile: true,
})
