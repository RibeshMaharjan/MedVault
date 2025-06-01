# 3.5 Algorithm Details

## 1. Moving Average Algorithm

A moving average algorithm calculates the average of a dataset over a specific period, and as new data points are added, the average "moves" forward, recalculating the average using the latest data.

### How It Works

1. **Purpose**: The moving average algorithm smooths out short-term fluctuations in sales data to reveal longer-term trends.
2. **Parameters**:
   - data: An array of sales amounts
   - windowSize: The number of data points to include in each average calculation (set to 5 in your implementation)
3. **Algorithm Steps**:
   - For each data point at index i, the algorithm:
     - Determines the starting index for the window (start = Math.max(0, i - windowSize + 1))
     - Calculates the sum of all values within the window
     - Divides the sum by the number of values in the window
     - Adds the result to the output array
   - Array data is then shown in chart

### Mathematical Expression:

For a simple moving average (SMA):

$$MA_t = \frac{1}{n} \sum_{i=0}^{n-1} P_{t-i}$$

Where:
- $MA_t$ is the moving average at time t
- $n$ is the window size
- $P_{t-i}$ is the data point at time t-i

For a weighted moving average (WMA) as implemented in the system:

$$WMA_t = \frac{\sum_{i=0}^{n-1} w_i \times P_{t-i}}{\sum_{i=0}^{n-1} w_i}$$

Where:
- $WMA_t$ is the weighted moving average at time t
- $n$ is the window size
- $w_i$ is the weight assigned to data point at position i
- $P_{t-i}$ is the data point at time t-i
- $\sum_{i=0}^{n-1} w_i$ is the sum of all weights

## 2. Anomaly Detection

Anomaly detection is the process of identifying rare or unexpected patterns in data that deviate significantly from the norm.

### How It Works

1. **Purpose**: The moving average algorithm smooths out short-term fluctuations in sales data to reveal longer-term trends.
2. **Parameters**:
   - data: An array of sales amounts
   - threshold: The z-score threshold for anomaly detection (default is 2, meaning values more than 2 standard deviations from the mean are considered anomalies)
3. **Algorithm Steps**:
   - Calculate the mean of the data
   - Calculate the standard deviation of the data
   - For each data point, calculate its z-score (the number of standard deviations it is from the mean)
   - Identify data points with z-scores exceeding the threshold as anomalies
   - Return the indices of the anomalous data points

### Mathematical Expression:

$$z_i = \frac{x_i - \mu}{\sigma}$$

Where:
- $z_i$ is the z-score for data point i
- $x_i$ is the value of data point i
- $\mu$ is the mean of the dataset
- $\sigma$ is the standard deviation of the dataset

A data point is considered an anomaly if:

$$|z_i| > threshold$$

Where:
- $threshold$ is typically set to 2 or 3 standard deviations
