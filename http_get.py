import requests
payload = {"sensor_id": "100001", "value": "5"}
r = requests.get("http://18.222.94.171/cas40.php", params=payload)
print(r.url)
print(r.status_code)
print(r.text)
# http://18.222.94.171/cas40.php?sensor_id=100001&value=5