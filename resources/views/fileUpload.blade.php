<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
        }

        .formbold-mb-5 {
            margin-bottom: 20px;
        }

        .formbold-pt-3 {
            padding-top: 12px;
        }

        .formbold-main-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .formbold-form-wrapper {
            margin: 0 auto;
            max-width: 550px;
            width: 100%;
            background: white;
        }

        .formbold-form-label {
            display: block;
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            margin-bottom: 12px;
        }

        .formbold-form-label-2 {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .formbold-file-input {
            position: relative;
            border: 1px dashed #e0e0e0;
            border-radius: 6px;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            text-align: center;
        }


        .formbold-form-input:focus {
            border-color: #6a64f1;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold-btn {
            text-align: center;
            font-size: 16px;
            border-radius: 6px;
            padding: 14px 32px;
            border: none;
            font-weight: 600;
            background-color: #6a64f1;
            color: white;
            cursor: pointer;
        }

        .formbold-btn:hover {
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold--mx-3 {
            margin-left: -12px;
            margin-right: -12px;
        }

        .formbold-px-3 {
            padding-left: 12px;
            padding-right: 12px;
        }

        .flex {
            display: flex;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .w-full {
            width: 100%;
        }

        .formbold-file-input input {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .formbold-file-input label {
            cursor: pointer;
            position: relative;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            text-align: center;
            width: 100%;
            height: 100%;
        }

        .formbold-drop-file {
            display: block;
            font-weight: 600;
            color: #07074d;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .formbold-or {
            font-weight: 500;
            font-size: 16px;
            color: #6b7280;
            display: block;
            margin-bottom: 8px;
        }

        .formbold-browse {
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            display: inline-block;
            padding: 8px 28px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .formbold-file-list {
            border-radius: 6px;
            background: #f5f7fb;
            padding: 16px 32px;
        }

        .formbold-file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .formbold-file-item button {
            color: #07074d;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .formbold-file-name {
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            padding-right: 12px;
        }

        .formbold-progress-bar {
            margin-top: 20px;
            position: relative;
            width: 100%;
            height: 6px;
            border-radius: 8px;
            background: #e2e5ef;
        }

        .formbold-progress {
            position: absolute;
            width: 75%;
            height: 100%;
            left: 0;
            top: 0;
            background: #6a64f1;
            border-radius: 8px;
        }

        @media (min-width: 540px) {
            .sm\:w-half {
                width: 50%;
            }
        }
    </style>
</head>

<body>
    <div>
        <div class="formbold-main-wrapper">
            <div class="formbold-form-wrapper">
                <form action="{{ route('fileUpload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="mb-6 pt-4">
                        <label class="formbold-form-label formbold-form-label-2 text-center">
                            Upload File
                        </label>

                        <div class="formbold-mb-5 formbold-file-input">
                            <input type="file" name="file" id="file" required/>
                            <label for="file">
                                <div>
                                    <span class="formbold-drop-file"> Drop files here </span>
                                    <span class="formbold-or"> Or </span>
                                    <span class="formbold-browse"> Browse </span>
                                </div>
                            </label>
                        </div>

                        <div class="formbold-file-list formbold-mb-5" id="file-list">
                            <!-- File list will be updated here -->
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="formbold-btn w-full">Send File</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <script>
        const fileInput = document.getElementById('file');
        const fileList = document.getElementById('file-list');

        fileInput.addEventListener('change', updateFileList);

        function updateFileList() {
            // Ensure file list is updated only if files have actually changed
            if (fileInput.files.length === 0) {
                fileList.innerHTML = ''; // Clear file list if no files are selected
                return;
            }

            fileList.innerHTML = ''; // Clear existing file list

            Array.from(fileInput.files).forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.classList.add('formbold-file-item');

                const fileName = document.createElement('span');
                fileName.classList.add('formbold-file-name');
                fileName.textContent = file.name;

                const removeButton = document.createElement('button');
                removeButton.innerHTML = `
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z" fill="currentColor"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z" fill="currentColor"/>
                    </svg>
                `;

                removeButton.addEventListener('click', () => {
                    // Remove file from the list
                    const newFiles = Array.from(fileInput.files).filter((_, i) => i !== index);
                    const dataTransfer = new DataTransfer();
                    newFiles.forEach(file => dataTransfer.items.add(file));
                    fileInput.files = dataTransfer.files;

                    // Re-render the file list
                    updateFileList();
                });

                fileItem.appendChild(fileName);
                fileItem.appendChild(removeButton);
                fileList.appendChild(fileItem);
            });
        }
    </script>

</body>

</html>
