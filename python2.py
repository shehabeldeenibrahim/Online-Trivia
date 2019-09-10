url = "http://localhost:5001/upload_64"
		image = {'image_64': image_string}
		r = requests.post(url,data = image)